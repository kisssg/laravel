<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">Dear {{ucfirst(strtolower($name))}},<br><br>
    您有一条违规需要确认处罚：<br>
    You've got a violation to confirm:<br>

    <table border="0" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td>
                <a href="{{ URL::to('confirm-violation/' .$id.'/'.  $token) }}" style="background-color: #3490dc;
                   border-top: 10px solid #3490dc;
                   border-right: 18px solid #3490dc;
                   border-bottom: 10px solid #3490dc;
                   border-left: 18px solid #3490dc;
                   text-decoration: none;" target="_blank"><span style="color:white;">Feedback</span></a>
            </td>
        </tr>
    </table>
    请在{{$dueIn}}前提交反馈。
    Please submit feedback before {{$dueIn}}.<br><br><br>

    <div style="font-size: 12px;color: gray">
        请点击链接提交反馈，不要直接回复本邮件。请注意本链接仅能通过内网访问，外网请通过ＶＰＮ访问。<br/>
        Please submit feedback through link above, don't reply this email. Please be noted this link can only be viewed through LAN or VPN.<br>
        若点击链接无反应，请复制链接到浏览器打开, Copy link to browser if unable to click button above：<br>
        {{ URL::to('confirm-violation/' .$id.'/'.  $token) }}
    </div>
    <br/>
    Best regards,<br/>
    Late collection QM
</table>