#!/bin/sh

trap ctrl_c INT

function ctrl_c() {
  echo "** Trapped CTRL-C"
}

for i in {1025..65536}
do
  # echo "port $i"
  php -S localhost:$i -t ./public &
  PID=$!
  # echo $PID

  sleep 0.1
  # Kill it
  #kill $PID
  kill -INT $PID
done

# sh ports.sh 2>&1 | tee ports.log