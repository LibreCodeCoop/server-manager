
# Install and configure a Ubuntu server from scratch

Access the server using ssh
```ssh root@<ip>```

After the instalation, root will not access ssh anymore. Configure a strong password to your root user. You can generate a password using
```
wget -O password http://www.passwordrandom.com/query?command=password
echo "Password: $(cat password)"
```

To proceed to update password of root do
```passwd```

> Don't forget of save the password used!

Download this project
```git clone https://github.com/LyseonTech/ubuntu-server-start.git installer```

Run the command above
```installer/run.sh 17.12.0~ce-0~ubuntu heimdall yes yes```