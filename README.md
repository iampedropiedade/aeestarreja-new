# Run the project in a new server

```bash
$ make ssh
$ sudo apt update
$ apt install make
$ sudo apt install nginx
$ sudo apt install apt-transport-https ca-certificates curl software-properties-common
$ curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
$ sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu focal stable"
$ apt-cache policy docker-ce
$ sudo apt install docker-ce
$ cd /home && mkdir aeestarreja && cd aeestarreja
$ ssh-keygen -t rsa -C "pedro@nitrogenio.net"
$ eval $(ssh-agent -s)
$ ssh-add ~/.ssh/id_rsa
$ cat ~/.ssh/id_rsa.pub
```

Add the key to github

Copy the Database

```bash
$ make build
$ make ui
$ make deploy
```

# Add the nginx configuration

```bash
$ vi /etc/nginx/sites-available/default 
```

Add, then save and exit:
```
location / {
    proxy_pass http://127.0.0.1:8090/;
    include proxy_params;
}
```

```bash
$ sudo systemctl reload nginx
```