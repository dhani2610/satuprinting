@extends('backend.layouts-new.app')

@section('title')
    Dashboard Page - Admin Panel
@endsection


@section('content')
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endsection

<!--/ Add New Credit Card Modal -->
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>


    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Statistik Pendapatan',
                align: 'left'
            },
            subtitle: {
                text: 'Periode: {{ $tahun }}',
                align: 'left'
            },
            xAxis: {
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December'
                ],
                crosshair: true,
                accessibility: {
                    description: 'Months'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Pendapatan'
                }
            },
            tooltip: {
                valueSuffix: ' Rp.',
                pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y:,.0f}</b><br/>'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: 'Rp. {point.y:,.0f} ',
                        style: {
                            color: '#333'
                        }
                    }
                }
            },
            series: [{
                    name: 'Pendapatan',
                    data: @json($charts_pendapatan),
                    color: 'green' // Warna hijau
                }
            ]
        });

        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    </script>

    <script>
        let currentPage = 1;
        const itemsPerPage = 5;

        function fetchTimelineData(page) {
            $.ajax({
                url: `{{ route('project.get.activity.dashboard') }}`,
                method: 'GET',
                success: function(response) {
                    console.log('====================================');
                    console.log(response);
                    console.log('====================================');
                    if (response.data.length > 0) {
                        renderTimeline(response);
                        if (response.data.length < itemsPerPage) {
                            $('#load-more').hide();
                        } else {
                            $('#load-more').show();
                        }
                    } else {
                        $('#load-more').hide();
                    }
                },
                error: function(xhr) {
                    console.error('An error occurred:', xhr);
                }
            });
        }

        function renderTimeline(response) {
            const timeline = $('#timeline-container .timeline');
            response.data.forEach(item => {
                let timelineClass = '';
                let indicatorClass = '';
                let iconClass = '';
                let content = '';

                switch (item.type) {
                    case 'Documentation':
                        timelineClass = 'timeline-item-warning';
                        indicatorClass = 'timeline-indicator-warning';
                        iconClass = 'bx-photo-album';
                        content =
                            `<img src="${item.file}" class="rounded me-3" alt="Shoe img" height="auto" width="100">`;
                        break;
                    case 'Certificate':
                        timelineClass = 'timeline-item-primary';
                        indicatorClass = 'timeline-indicator-primary';
                        iconClass = 'bx-file';
                        content = item.content ?
                            `<p>${item.content}</p><a href="javascript:void(0)" onclick="showLampiranEdit('${item.file}')"><i class="bx bx-link"></i> Certificate.pdf</a>` :
                            `<p>Sertifikat belum di upload</p>`;
                        break;
                    case 'SIMBG':
                        timelineClass = 'timeline-item-success';
                        indicatorClass = 'timeline-indicator-success';
                        iconClass = 'bx-message-square-check';
                        content = item.content; // Assuming item.content holds the necessary HTML or text
                        break;
                    case 'Kajian':
                        timelineClass = 'timeline-item-info';
                        indicatorClass = 'timeline-indicator-info';
                        iconClass = 'bx-spreadsheet';
                        content = item.content; // Assuming item.content holds the necessary HTML or text
                        break;
                    case 'Survey':
                        timelineClass = 'timeline-item-dark';
                        indicatorClass = 'timeline-indicator-dark';
                        iconClass = 'bx-car';
                        content = `<p>${item.content}</p>`;
                        break;
                    case 'Document':
                        timelineClass = 'timeline-item-danger';
                        indicatorClass = 'timeline-indicator-danger';
                        iconClass = 'bxs-file-image';
                        content = item.content; // Assuming item.content holds the necessary HTML or text
                        break;
                }
                const appUrl = '{{ env('APP_URL') }}'; // Replace with your actual app URL


                const users = response.user;
                const getUserById = (userId) => users.find(user => user.id === userId);
                const user = getUserById(item.action_by);
                // Prepare user avatar and name
                const userAvatar = user && user.foto ? `assets/img/team/${user.foto}` : 'default-avatar.png';
                const userName = user ? user.name : 'Unknown User';
                console.log(userAvatar, userName);

                const timelineItem = `
                <li class="timeline-item pb-4 ${timelineClass} border-left-dashed">
                    <span class="timeline-indicator-advanced ${indicatorClass}">
                        <i class="bx ${iconClass}"></i>
                    </span>
                    <div class="timeline-event">
                        <div class="timeline-header border-bottom mb-3">
                            <h6 class="mb-0">${item.type}</h6>
                            <span class="text-muted">${new Date(item.date).toLocaleDateString('id-ID')}</span>
                        </div>
                        ${content}
                        <hr>
                        <div class="d-flex flex-wrap">
                            <div class="d-flex flex-wrap align-items-center">
                                <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 my-3 me-2">
                                 ${item.action_by ? 
                                    `<li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" aria-label="${getUserById(item.action_by).name}" data-bs-original-title="${getUserById(item.action_by).name}">
                                                        <img class="rounded-circle" src="${appUrl}/assets/img/team/${getUserById(item.action_by).foto}" alt="Avatar">
                                                    </li>` :
                                    ''
                                    }
                                </ul>
                            </div>
                            <div>
                                <p class="mb-0">${userName}</p>
                                <span class="text-muted">Project</span>
                            </div>
                        </div>
                    </div>
                </li>
            `;
                timeline.append(timelineItem);
            });
        }


        $(document).ready(function() {
            fetchTimelineData(currentPage);

            $('#load-more').on('click', function() {
                currentPage++;
                fetchTimelineData(currentPage);
            });
        });
    </script>
@endsection
