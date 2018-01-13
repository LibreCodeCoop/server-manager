
# Install and configure a Ubuntu server from scratch

Access the server using ssh
```ssh root@<ip>```

After the instalation, root will not access ssh anymore. Configure a strong password to your root user. You can generate a password using
```
wget -O password http://www.passwordrandom.com/query?command=password && \
	password=$(cat password) && \
    echo "Password: $password"
```

To proceed to update password of root do
```passwd```

Download this project
```git clone https://github.com/LyseonTech/ubuntu-server-start.git installer```

Run the command above
```installer/run.sh 17.12.0~ce-0~ubuntu heimdall yes yes```