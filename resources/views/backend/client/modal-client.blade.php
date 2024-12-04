<!-- Modal for Project Activities -->
<div class="modal fade" id="modalactivity-{{ $proj->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <center>
                    <h5 class="modal-title" id="exampleModalLabel">
                        Activity Project {{ $proj->name_project }}
                    </h5>
                </center>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-4">
                <div class="card-body">
                    <div id="timeline-container-{{ $proj->id }}">
                        <ul class="timeline pt-3">
                            <!-- Timeline items will be filled here -->
                        </ul>
                        <div class="text-center mt-3">
                            <button id="load-more-{{ $proj->id }}" class="btn btn-primary">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
// Function to fetch and render timeline data based on project ID
let currentPage = 1;
const itemsPerPage = 5;
function fetchTimelineData(projectId, page) {
    $.ajax({
        url: `{{ url('/admin/project/data-activity') }}/${projectId}?page=${page}`,
        method: 'GET',
        success: function(response) {
            console.log('Response:', response);
            if (response.data.length > 0) {
                renderTimeline(response, projectId);
                if (response.data.length < itemsPerPage) {
                    $(`#load-more-${projectId}`).hide();
                } else {
                    $(`#load-more-${projectId}`).show();
                }
            } else {
                $(`#load-more-${projectId}`).hide();
            }
        },
        error: function(xhr) {  
            console.error('An error occurred:', xhr);
        }
    });
}

// Function to render the timeline items
function renderTimeline(response, projectId) {
    const timeline = $(`#timeline-container-${projectId} .timeline`);
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
                content = item.content;
                break;
            case 'Kajian':
                timelineClass = 'timeline-item-info';
                indicatorClass = 'timeline-indicator-info';
                iconClass = 'bx-spreadsheet';
                content = item.content;
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
                content = item.content;
                break;
        }
        const appUrl = '{{ env('APP_URL') }}'; // Base URL

        const users = response.user;
        const getUserById = (userId) => users.find(user => user.id === userId);
        const user = getUserById(item.action_by);
        const userAvatar = user && user.foto ? `${appUrl}/assets/img/team/${user.foto}` : `${appUrl}/assets/img/team/default-avatar.png`;
        const userName = user ? user.name : 'Unknown User';

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
                                `<li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" aria-label="${userName}" data-bs-original-title="${userName}">
                                    <img class="rounded-circle" src="${userAvatar}" alt="Avatar">
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

// Attach event handlers when document is ready
$(document).ready(function() {
    // let currentPage = 1; // Define currentPage here
    // const itemsPerPage = 5;
    // Set up click events for each modal trigger
    $('[id^="modalactivity-"]').each(function() {
        const projectId = $(this).attr('id').split('-')[1];
        $(this).on('shown.bs.modal', function() {
            fetchTimelineData(projectId, currentPage);
        });
        $(`#load-more-${projectId}`).on('click', function() {
            currentPage++;
            fetchTimelineData(projectId, currentPage);
        });
    });
});

</script>