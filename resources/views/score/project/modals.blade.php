<!--score card-->
<div class="modal fade bs-score-card" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" role="document">        
        <score-card project_id='{{ $project->id}}' ref='scoreCard' :key="scoreCardKey"></score-card>
    </div>
</div>
<!--end of score card-->