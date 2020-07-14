/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function switch_check_all(src) {
    check_boxes = (document.getElementsByName('checkbox_id'));
    for (i = 0; i < check_boxes.length; i++) {
        check_boxes[i].checked = src.checked;
    }
}
function getChecked() {
    check_boxes = document.getElementsByName('checkbox_id');
    checked = [];
    for (i = 0; i < check_boxes.length; i++) {
        if (check_boxes[i].checked) {
            data = (check_boxes[i].value).split(',');
            idEmail = {"id": data[0], "email": data[1]};
            checked.push(idEmail);
        }
    }
    return checked;
}

function sendFeedbackLinks() {
    checked = getChecked();
    if (checked.length < 1) {
        alert('未选择任何数据！');
        return;
    }
    cf = confirm('确认批量发送反馈收集邮件吗？');
    if (!cf) {
        return;
    }
    args = {
        'idEmails': checked
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post('sendlinks', args, function (data) {
        alert(data.result);
    }, 'json');
}

function setEmails(lastInput) {
    checked = getChecked();
    if (lastInput) {
        email = prompt('请输入邮箱地址', lastInput);
    } else {
        email = prompt('请输入邮箱地址', "@homecredit.cn");
    }
    if (email === null || undefined) {
        return;
    }
    emailCheck = (email.match(/[a-zA-Z0-9]{1,10}\.[a-zA-Z0-9]{1,10}@homecredit\.cn/));
    if (emailCheck === null) {
        alert('请输入正确的邮件地址');
        return setEmails(email);
    }
    args = {
        'ids': checked,
        'email': email
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //console.log(checked);
    $.post('set/email', args, function (data) {
        console.log(data);
        window.location = window.location.href;
    }, 'json');

}
function setProposals() {
    checked = getChecked();
    bonusReduction = document.getElementById('bonus_reduction_propose').value;
    bonusReduction = (Number(bonusReduction) / 100).toFixed(2);
    action = document.getElementById('action_propose').value;
    evidence = document.getElementById('evidence').value;
    if (checked.length < 1) {
        alert('请选择要设置建议处罚的数据');
        return;
    }
    args = {
        "bonus_reduction": bonusReduction,
        "action_level": action,
        "ids": checked,
        "punishment_evidence": evidence
    };
    console.log(args);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post('propose', args, function (data) {
        if (data.result === 'success') {
            alert('ok');
            document.getElementById('bonus_reduction_propose').value = '';
            document.getElementById('action_propose').value = '';
        } else {
            alert(JSON.stringify(data));
        }
    }, 'json');
}
function buildViolationFromIssue(btn) {
    startDate = (document.getElementById('start_date').value);
    endDate = document.getElementById('end_date').value;
    restartDate = startDate.match(/^\d{4}\-\d{2}\-\d{2}(\s\d\d\:\d\d\:\d\d)?$/);
    reendDate = endDate.match(/^\d{4}\-\d{2}\-\d{2}(\s\d\d\:\d\d\:\d\d)?$/);
    objectsBoxes = document.getElementsByName('objects');
    objects = [];
    for (i = 0; i < objectsBoxes.length; i++) {
        if (objectsBoxes[i].checked) {
            objects.push(objectsBoxes[i].value);
        }
    }
    console.log(objects);
    if (restartDate === null || reendDate === null) {
        alert('日期时间格式需为2019-09-09 23:00:00');
        return;
    }
    args = {
        'startDate': startDate,
        'endDate': endDate,
        'objects': objects
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    btn.value = '正在生成';
    btn.disabled = true;
    $.post('/violation/generate', args, function (data) {
        alert('总计' + data.total + '，其中包含刚刚生成的' + data.created + '条。');
        btn.value = '开始生成';
        btn.disabled = false;
        window.location = "/violation/search?s=[range:" + startDate + " " + endDate +"]";
    }, 'json');
}
function proposePreset(option) {
    console.log(option.value);
}

function searchViolation(btn) {
    channel = document.getElementById('channel').value;
    issueValue = document.getElementById('issue').value;
    
    statusValue = document.getElementById('status').value;
    collector = document.getElementById('collector').value;
    contract_no = document.getElementById('contract_no').value;
    range_start = document.getElementById('range_start').value;
    range_end = document.getElementById('range_end').value;
    combine = '';
    if (channel !== '') {
        combine += "[channel:" + channel + "]";
    }
    if (issueValue !== '') {
        combine += "[issue:" + issueValue + "]";
    }
    if (statusValue !== '') {
        combine += "[status:" + statusValue + "]";
    }
    if (collector !== '') {
        combine += "[collector:" + collector + "]";
    }
    if (contract_no !== '') {
        combine += "[contract_no:" + contract_no + "]";
    }
    if (range_start !== '' && range_end !== '') {
        combine += "[range:" + range_start + " " + range_end + "]";
    }
    console.log(combine);
    window.location='/violation/search?s='+combine;
}
/**
 * 
 * @param {type} src
 * @returns {undefined}
 */
    function switch_check_alli(src) {
        check_boxes = (document.getElementsByName('checkbox_lli'));
        for (i = 0; i < check_boxes.length; i++) {
            check_boxes[i].checked = src.checked;
        }
        return null;
    }
    function deleteCollector() {
        check_boxes = document.getElementsByName('checkbox_lli');
        checked = [];
        for (i = 0; i < check_boxes.length; i++) {
            if (check_boxes[i].checked) {
                checked.push(check_boxes[i].value);
            }
        }
        console.log(checked);
        args = {
            'ids': checked
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('collector/delete', args, function (data) {
            console.log(data);
        }, 'json');
    }
