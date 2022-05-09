docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
ECHO Y | docker image prune -a