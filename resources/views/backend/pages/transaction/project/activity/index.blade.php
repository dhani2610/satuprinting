@extends('backend.layouts-new.app')

@section('content')
    @php
        $po = \App\Models\PurchaseOrder::where('id', $proj->id_po)->first();
        $cust = App\Models\Admin::where('type', 'customer')
            ->where('id', $proj->id_customer)
            ->first();
        $poDetail = \App\Models\PurchaseOrderDetail::where('id_po', $proj->id_po)->get();
        $statecust = \App\Models\State::where('id', $cust->id_state)->first();
        $citycust = \App\Models\City::where('id', $cust->id_city)->first();
        $marketing = App\Models\Admin::where('id', $proj->id_marketing)->first();

    @endphp
    @include('backend.layouts.partials.messages')

    <div class="row">
        <!-- Customer-detail Sidebar -->
        @include('backend.pages.transaction.project.sidebar')
        <!--/ Customer Sidebar -->

        <!-- Customer Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- Customer Pills -->
            @include('backend.pages.transaction.project.tabs')
            <!-- Timeline Advanced-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div id="timeline-container">
                            <ul class="timeline pt-3">
                                <!-- Timeline items akan diisi di sini -->
                            </ul>
                            <div class="text-center mt-3">
                                <button id="load-more" class="btn btn-primary">Load More</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Timeline Advanced-->


        </div>
        <!--/ Customer Content -->
    </div>
    <!-- Modal for PDF Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewer" src="" width="100%" height="600px"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function showLampiranEdit(fileExist) {
            $('#pdfViewer').attr('src', fileExist);
            $('#previewModal').modal('show');
        }
    </script>

    <script>
        let currentPage = 1;
        const itemsPerPage = 5;

        function fetchTimelineData(page) {
            $.ajax({
                url: `{{ url('/admin/project/data-activity/' . $proj->id) }}?page=${page}`,
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
                        content = `<img src="${item.file}" class="rounded me-3" alt="Shoe img" height="auto" width="100">`;
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
                console.log(userAvatar,userName);

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
