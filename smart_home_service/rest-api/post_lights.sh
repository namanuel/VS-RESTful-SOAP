#!/usr/bin/env sh

http POST $HOST/api/lights x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77 <<JSON
{
"name": "garden"
}
JSON

http POST $HOST/api/lights x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77 <<JSON
{
"name": "living room"
}
JSON

http POST $HOST/api/lights x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77 <<JSON
{
"name": "garage"
}
JSON
