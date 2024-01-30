FROM node:21-alpine3.18

WORKDIR /var/www/vue
COPY /client/src/package.json ./

RUN npm install

COPY /client/src ./

EXPOSE 8080

CMD ["npm", "run", "serve"]