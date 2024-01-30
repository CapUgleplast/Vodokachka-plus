FROM node:21-alpine3.18

WORKDIR /var/www/vue
COPY ./src/package.json ./

RUN npm install

COPY ./src ./

EXPOSE 8080

CMD ["npm", "run", "dev"]