#!/bin/bash

echo 'Installing FFMPEG with CPU and GPU Support: '
mkdir -p /opt/ffmpeg
cd /opt/ffmpeg
wget http://slipstreamiptv.com/downloads/ffmpegv3_cpu_gpu.zip
unzip ffmpegv3_cpu_gpu.zip
cd ffmpegv3_cpu_gpu
cp * /usr/bin
chmod 777 /usr/bin/ffprobe
chmod 777 /usr/bin/ffmpeg

echo "Finished."
