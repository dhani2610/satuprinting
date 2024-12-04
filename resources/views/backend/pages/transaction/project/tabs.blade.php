<ul class="nav nav-pills flex-column flex-md-row mb-4">
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'project.activity' ? 'active' : '' }}" href="{{ route('project.activity', $proj->id) }}">
            <i class="bx bx-user me-1"></i>Activity
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'project.document' ? 'active' : '' }}" href="{{ route('project.document', $proj->id) }}">
            <i class="bx bxs-file-image me-1"></i>Document
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'survey.project' ? 'active' : '' }}" href="{{ route('survey.project', $proj->id) }}">
            <i class="bx bx-car me-1"></i>Survey
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'kajian.project' ? 'active' : '' }}" href="{{ route('kajian.project', $proj->id) }}">
            <i class="bx bx-spreadsheet me-1"></i>Kajian
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'simbg.project' ? 'active' : '' }}" href="{{ route('simbg.project', $proj->id) }}">
            <i class="bx bx-message-square-check me-1"></i>SIMBG
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'certificate.project' ? 'active' : '' }}" href="{{ route('certificate.project', $proj->id) }}">
            <i class="bx bx-file me-1"></i>Certificate
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'documentation.project' ? 'active' : '' }}" href="{{ route('documentation.project', $proj->id) }}">
            <i class="bx bx-photo-album me-1"></i>Documentation
        </a>
    </li>
</ul>
