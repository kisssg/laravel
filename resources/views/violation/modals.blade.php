<div class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class='modal-header'>
                <h4 class=modal-title>Issue数据生成violation数据</h4>
            </div>
            <div class='modal-body'>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="objects" id="inlineCheckbox1" value="外催员/法律调查员" checked="true">
                        <label class="form-check-label" for="inlineCheckbox1">外催员/法律调查员</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="objects" id="inlineCheckbox2" value="外包公司">
                        <label class="form-check-label" for="inlineCheckbox2">外包公司</label>
                    </div>
                </div>
                <div class='form-group form-inline'>
                    <input class="form-control form-group" type='date'id='start_date'value='' placeholder="start date"/>-
                    <input class="form-control form-group" type='date' id='end_date' value='' placeholder="end date"/>
                </div>

            </div>
            <div class='modal-footer'>
                <input type="button" class="btn btn-primary" onclick="return buildViolationFromIssue(this)" value="开始生成"/>
            </div>     
        </div>
    </div>
</div>

<div class="modal fade bs-propose-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class='modal-header'>
                <h4 class=modal-title>设定建议处罚</h4>
            </div>
            <div class='modal-body'>
                <div class="form-group">
                    <div class="input-group ">
                        <input type="number" class="form-control" id='bonus_reduction_propose' placeholder="bonus reduction" aria-label="bonus reduction" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                    <input class="form-control form-group" id='action_propose' value='' placeholder="action"/>
                    <div class="form-group">
                        <label for="evidence">Evidence 依据:</label>
                        <textarea class="form-control form-group" id="evidence" rows="5"></textarea>
                    </div>
                </div>
            </div>     
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" onclick="return setProposals(this)" value="确定"/></div>
        </div>
    </div>
</div>

<div class="modal fade bs-search-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class='modal-header'>
                <h4 class=modal-title>多项搜索</h4>
            </div>
            <div class='modal-body'>
                <div class="form-group">
                    Range
                    <div class="form-group form-inline">
                        <input type="date" class="form-control form-group" v-model='range_start'/>-<input type="date" class="form-control form-group" v-model='range_end'/>
                    </div>
                </div>
                <div class="form-group">
                    Channel<select class="form-control form-group" v-model='channel'>
                        <option>field</option>
                        <option>agency</option>                       
                    </select>
                </div>
                <div class="form-group">
                    Issue
<v-select id="issue" :options="options" v-model="selectedIssue" @search="fetchOptions"/>
                </div>
                <div class="form-group">
                    Status<select class="form-control form-group" v-model='statusValue' aria-describedby="statusHelpBlock">
                        <option>waiting</option>
                        <option>proposed</option>
                        <option>rm approved</option>
                        <option>cm approved</option>
                    </select>                    
                    <small id="statusHelpBlock" class="form-text text-muted">
                        waiting:刚刚生成的;proposed:建议处罚已设置;rm approved:区域经理已确认;cm approved:全国经理已确认;
                    </small>
                </div>
                <div class="form-group">
                    Collector<input class="form-control form-group" v-model='collector'/>
                </div>
                <div class="form-group">
                    Contract No.<input class="form-control form-group" v-model='contract_no'/>
                </div>
            </div>     
            <div class="modal-footer">
                <input type="button" class="btn btn-primary"  v-on:click="searchViolation" value="Search"/></div>
        </div>
    </div>
</div>
