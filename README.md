# NoticeStatus

## Magento 2 - Notification Status Extension

The extension is designed to control the sending of notifications (email, sms, etc). 

The extension will be useful if you need to send out repeated notifications (once a day, a week, a month, a year, a specified number of times) and control this process.



### Example 1 - Sending daily notices with coupons

Code:
```php
$recordId = 10; //coupon id
$recordType = "daily_coupon"; //unique type for coupon records
$dayNumber = 1; //daily
$noticeType = 1; //email type

if(isNoticeSentByDayNumber($recordId, $recordType, $dayNumber, $noticeType)){
    return;
} else {
    //send coupon code
    $isSend = 1; //status
    $count = 1; //count of sending times
    createNotice($recordId, $recordType, $isSend, $count);
}
```

### Example 2 - Send news every week

Code:
```php
$recordId = 99; //news record id
$recordType = "weekly_news"; //unique type for news records

if(isNoticeSentWeek($recordId, $recordType)){
    return;
} else {
    //send email code
    $isSend = 1; //status
    $count = 1; //count of sending times
    createNotice($recordId, $recordType, $isSend, $count);
}
```
