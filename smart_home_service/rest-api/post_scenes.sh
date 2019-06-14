#!/usr/bin/env sh

http POST $HOST/api/scenes x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77 <<JSON
[
  { "name": "party", "light_id": "81962729-6082-43a1-86f0-7d0dd8f9bd58", "brightness": "10" , "status": "1"},
  { "name": "party", "light_id": "05e6a7f9-5694-44da-b9a5-45ef513e8dd5", "brightness": "20" , "status": "1"},
  { "name": "party", "light_id": "97516cd2-1572-4357-b84f-4d8f4eb42d85", "brightness": "30" , "status": "1"}
]
JSON

