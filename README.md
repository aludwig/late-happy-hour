# late-happy-hour

There are 4 total pages to this website:
-  Home
-  List
-  Details
-  About

All content is attached to index.html.  Home & About are (mostly) static content.  List is built per the selected day and region filters found on the Home page, and loaded into index.html via AJAX.  Details is built per the selected list item (WhenHub Event list) and loaded into index.html via AJAX.

Home:
The list of regions/cities is dynamically generated based on the WhenHub Schedules that are available in my account (they're named "Los Angeles", etc).

List:
The list items are generated per the WhenHub Events found in the selected WhenHub Schedule, which match the days filter (WhenHub Event Recurrence Rule weekly selected days).

Details:
The selected list item id is passed to the Details page, which displays the WhenHub Event data.
