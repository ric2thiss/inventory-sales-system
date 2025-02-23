# **Docker Installation and Container Creation on a Linux System**

## Step 1: Update System Packages

Before installing Docker, update the system package index to ensure you get the latest version.

```bash
sudo apt update && sudo apt upgrade -y
```

## Step 2: Install Required Dependencies

Install required dependencies to allow the use of repository over HTTPS.

```bash
sudo apt install apt-transport-https ca-certificates curl software-properties-common -y
```

## Step 3: Add Docker’s Official GPG Key

```bash
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
```

## Step 4: Add Docker Repository

```bash
echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```

## Step 5: Install Docker Engine

Update the package list again and install Docker.

```bash
sudo apt update
sudo apt install docker-ce docker-ce-cli containerd.io -y
```

## Step 6: Verify Docker Installation

Check if Docker is installed correctly by running:

```bash
docker --version
```

Check the Docker service status:

```bash
sudo systemctl status docker
```

Enable Docker to start on boot:

```bash
sudo systemctl enable docker
```

## Step 7: Add User to Docker Group (Optional)

To use Docker without `sudo`, add your user to the `docker` group:

```bash
sudo usermod -aG docker $USER
```

Log out and log back in for changes to take effect.

## Step 8: Pull a Linux Container Image

Pull an official Ubuntu image from Docker Hub.

```bash
docker pull ubuntu:latest
```

## Step 9: Create and Run a Linux Container

Run a container from the Ubuntu image and name it with your last name.

1. Run a new container interactively:

```bash
docker run -it --name your_lastname ubuntu
```

2. Verify that the container is created:

```bash
docker ps -a
```

3. Start the container (if it's not running):

```bash
docker start your_lastname
```

4. Attach to the container's shell:

```bash
docker exec -it your_lastname bash
```

```bash
docker run -it --name your_lastname ubuntu
```

The `-it` flag allows interactive mode, and `--name your_lastname` assigns a specific name to the container.

## Step 10: Verify Running Containers

Check if the container is running:

```bash
docker ps -a
```

## Step 11: Access the Running Container

To enter the container’s shell, use:

```bash
docker exec -it your_lastname bash
```

## Step 12: Stop and Remove the Container

To stop the container:

```bash
docker stop your_lastname
```

To remove the container:

```bash
docker rm your_lastname
```

## Conclusion

This guide provided a step-by-step process to install Docker using only the terminal, pull a Linux-based container, and perform basic container management tasks.

