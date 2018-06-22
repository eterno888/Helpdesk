<div class="sidebar" id="sidebar">
    <div class="show-mobile absolute ml2 mt-2 fs3">
        <span class="fs3 white" onclick="toggleSidebar()">X</span>
    </div>
    <img src="{{ url("/images/handesk_small.png") }}">

    <!--Раздел заявок-->
    @include('layouts.sidebar.tickets')
    <br>

    <!--Раздел новостей
    <h4> @icon(newspaper-o)  {{ __('news.news') }}</h4>
    <ul>

    </ul>
    <br>

    <!-Раздел базы знаний--
    <h4> @icon(question-circle-o) {{ __('knowledgebase.knowledgebase') }}</h4>
    @include('components.sidebarItem', ["url" => route('knowledgebase.index'), "title" => __('knowledgebase.knowledgebase') ])
    <br>
    -->

<!--Раздел отчетов-->
    <h4> @icon(bar-chart) {{ trans_choice('report.report', 2) }}</h4>
    <ul>
        @include('components.sidebarItem', ["url" => route('statistics.index'), "title" => trans_choice('report.statistics', 2) ])
        @include('components.sidebarItem', ["url" => route('reports.index'), "title" => trans_choice('report.report', 2) ])
    </ul>
    <br>

    <!--Раздел панели админа-->
    @if(auth()->user()->admin)
        <h4> @icon(cog) {{ __('admin.admin') }}</h4>
        <ul>
            @include('components.sidebarItem', ["url" => route('teams.index'),"title" => trans_choice('team.team', 2)])
            @include('components.sidebarItem', ["url" => route('users.index'),"title" => trans_choice('ticket.user', 2)])
            @include('components.sidebarItem', ["url" => route('news.index'), "title" => __('news.news') ])
        </ul>
        <br>
    @endif
</div>

<div class="show-mobile absolute ml2 mt3 fs3">
    <span class="fs3 black" onclick="toggleSidebar()">☰</span>
</div>