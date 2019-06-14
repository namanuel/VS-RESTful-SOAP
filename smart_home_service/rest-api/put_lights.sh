#!/usr/bin/env sh

# http PUT $HOST/api/lights x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77 <<JSON
# {
# "brightness": "33",
# "status": "1"
# }
# JSON

http PUT $HOST/api/lights/84da0514-e4c5-4330-8221-d2982d703475 x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77 <<JSON
{
"status": "1",
"brightness": "50"
}
JSON

