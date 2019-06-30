# NoticeStatus

## Magento 2 - Notification Status Extension

The extension is designed to control the sending of notifications (email, sms, etc). 

The extension will be useful if you need to send out repeated notifications (once a day, a week, a month, a year, a specified number of times) and control this process.

### Example 1 - Sending daily notices with coupons

Code:
```php
        /** @var NoticeApi $noticeApi */
        $noticeApi = ObjectManager::getInstance()->get(NoticeApi::class);

        $recordId = 10; //coupon id
        $recordType = "daily_coupon"; //unique type for coupon records
        $dayNumber = 1; //daily

        if (!$noticeApi->isNoticeSentByDayNumber($recordId, $recordType, $dayNumber, NoticeInterface::TYPE_EMAIL)) {
            $isSend = 1; //status
            $count = 1; //count of sending times
            $noticeApi->createNoticeByParams($recordId, $recordType, NoticeInterface::TYPE_EMAIL, $isSend, $count);//send coupon code
        }
```

### Example 2 - Send news every week

Code:
```php
        /** @var NoticeApi $noticeApi */
        $noticeApi = ObjectManager::getInstance()->get(NoticeApi::class);

        $recordId = 99; //news record id
        $recordType = "weekly_news"; //unique type for news records

        if (!$noticeApi->isNoticeSentWeek($recordId, $recordType)) {
            $isSend = 1; //status
            $count = 1; //count of sending times
            $noticeApi->createNoticeByParams($recordId, $recordType, NoticeInterface::TYPE_EMAIL, $isSend, $count);//send email code
        }
```
