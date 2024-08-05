# Run the project in a new server

```bash
$ make ssh
$ sudo apt update
$ apt install make
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




