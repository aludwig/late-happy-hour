# late-happy-hour

There are 4 total pages to this website:
-  Home
-  List
-  Details
-  About

All content is attached to and stems out of index.html.  Home & About are (mostly) static content.  The List page is built per the selected day and region filters (WhenHub Schedules) found on the Home page, and loaded into index.html via AJAX.  The Details page is built per the selected list item (WhenHub Event list) and loaded into index.html via AJAX.

Home Page:
The list of regions/cities is dynamically generated based on the WhenHub Schedules that are available in my account (they're named "Los Angeles", etc).  Each Schedule is a region full of Events (Late Happy Hours).

List Page:
The list items are generated per the WhenHub Events found in the selected WhenHub Schedule, which match the days filter (WhenHub Event Recurrence Rule weekly selected days).

Details Page:
The selected list item id is passed to the Details page, which displays the WhenHub Event data.

About Page:
Static content.
