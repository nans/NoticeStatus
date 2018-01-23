# NoticeStatus
Magento 2 - Notification Status Extension

The extension is designed to control the sending of notifications (email, sms, etc.).

The extension will be useful if you need to send out repeated notifications (once a day, a week, a month, a year, a specified number of times) and control this process.



Example: sending daily notices with coupons:

Record with coupons:
Id: 10
Body: some text

Code:

$recordId = 10;
$recordType = "daily_coupons";
$dayNumber = 1; //daily
$noticeType = 1; //email

if(isNoticeSentByDayNumber($recordId, $recordType, $dayNumber, $noticeType)){
    return
} else {
    //send notice
    $isSend = 1; //status
    $count = 1; //count of sending times
    createNotice($recordId, $recordType, $isSend, $count);
}
