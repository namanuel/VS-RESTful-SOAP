# Flask
# Author: Benjamin Medicke

FROM python:3.7

WORKDIR /usr/src/app

COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt

# document ports of interest:
EXPOSE 5000

CMD FLASK_APP=rest.py FLASK_DEBUG=1 flask run --host=0.0.0.0
