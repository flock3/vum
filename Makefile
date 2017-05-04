run:
	docker build -t vum .
	docker run  -p8080:80 -v `pwd`:/usr/share/nginx/html -eGOOGLE_CLIENT_ID=${GOOGLE_CLIENT_ID} -eGOOGLE_SECRET_KEY=${GOOGLE_SECRET_KEY} -eGOOGLE_REDIRECT_URI=${GOOGLE_REDIRECT_URI} -it vum
