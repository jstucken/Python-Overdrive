# Customise the welcome message when users SSH in
#
# The following bash_profile mods were adapted from:
# https://www.raspberrypi.org/forums/viewtopic.php?t=23440#p218787
# created by jstucken 12-6-2021
#

# If not running interactively, don't do anything
# this prevents Thonny getting errors on Python remote SSH interpreter connections
case $- in
    *i*) ;;
      *) return;;
esac

# jstucken mod 24-6-2021
# this is a cheap way of jailing students to their home dir
# and from running certain commands
# we do this by making bad aliases which restrict them from using certain commands
if [ "$USER" != "root" ] && [ "$USER" != "pi" ]; then

    #echo "Welcome, student user"
    # error message to display when student tries to use a restricted command
    STUDENT_ERROR_MSG="command not permitted"

	alias cd='echo "$STUDENT_ERROR_MSG"'
	alias pwd='echo "$STUDENT_ERROR_MSG"'
	alias vi='echo "$STUDENT_ERROR_MSG"'
	alias vim='echo "$STUDENT_ERROR_MSG"'
	alias nano='echo "$STUDENT_ERROR_MSG""'
	#alias cat='echo "$STUDENT_ERROR_MSG""'
	#alias head='echo "$STUDENT_ERROR_MSG""'
	#alias tail='echo "$STUDENT_ERROR_MSG""'
else
	# must be root or pi user
	# enter default directory
	cd /home/pi/DET-Python-Anki-Overdrive/
fi


# set a fancy prompt (non-color, unless we know we "want" color)
case "$TERM" in
    xterm-color) color_prompt=yes;;
esac

# uncomment for a colored prompt, if the terminal has the capability; turned
# off by default to not distract the user: the focus in a terminal window
# should be on the output of commands, not on the prompt
force_color_prompt=yes

if [ -n "$force_color_prompt" ]; then
    if [ -x /usr/bin/tput ] && tput setaf 1 >&/dev/null; then
  # We have color support; assume it's compliant with Ecma-48
  # (ISO/IEC-6429). (Lack of such support is extremely rare, and such
  # a case would tend to support setf rather than setaf.)
  color_prompt=yes
    else
  color_prompt=
    fi
fi

if [ "$color_prompt" = yes ]; then
    PS1='${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u@\h\[\033[00m\] \[\033[01;34m\]\w \$\[\033[00m\] '
else
    PS1='${debian_chroot:+($debian_chroot)}\u@\h:\w\$ '
fi
unset color_prompt force_color_prompt

# enable color support of ls and also add handy aliases
if [ -x /usr/bin/dircolors ]; then
    test -r ~/.dircolors && eval "$(dircolors -b ~/.dircolors)" || eval "$(dircolors -b)"
    alias ls='ls --color=auto'
    #alias dir='dir --color=auto'
    #alias vdir='vdir --color=auto'

    alias grep='grep --color=auto'
    alias fgrep='fgrep --color=auto'
    alias egrep='egrep --color=auto'
fi

# some more ls aliases
alias ll='ls -lah'

# for windows command prompt fans
alias dir='ls'

# show numerical chmod file attributes
alias lp='stat -c "%a %n"'

# brings up the DET Python Anki home screen with CPU usage etc
alias help='source /etc/bash.bashrc'

# allows user to control raspi desktop screen brightness
# uses this package: https://github.com/LordAmit/Brightness
alias brightness='python3 /home/pi/DET-Python-Anki-Overdrive/shell_scripts/brightness/Brightness-master/src/init.py'

# refreshes changes in the /etc/wpa_supplicant/wpa_supplicant.conf file
alias wifi='/home/pi/DET-Python-Anki-Overdrive/shell_scripts/refresh_wifi.sh'
alias refresh_wifi='/home/pi/DET-Python-Anki-Overdrive/shell_scripts/refresh_wifi.sh'

############################################################
############################################################
# CUSTOM WELCOME MESSAGES BELOW
CPU_USAGE=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_cpu.sh`
DISK_USAGE=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_disk_usage.sh`
MEM_USAGE=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_mem_usage.sh`
UPTIME=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_uptime.sh`
USERS_ONLINE=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_users_online.sh`
RASP_VERSION=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_rasp_version.sh`
LOCAL_IP=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_local_ip.sh`
KERNEL=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_kernel.sh`
DATE=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_date.sh`
VERSION=`/home/pi/DET-Python-Anki-Overdrive/shell_scripts/get_version.sh`

# define text colours
green=`tput setaf 10`
red=`tput setaf 2`
orange=`tput setaf 3`
white=`tput setaf 7`
light_blue=`tput setaf 6`
pink=`tput setaf 9`

# print out welcome message to user (same msg for root/pi and student users)
echo "${light_blue}
 *****************************************************
 **            DET Python Anki Overdrive            **
 **                   version ${VERSION}                   **
 *****************************************************"
echo "${pink}
 Raspbian version...: ${RASP_VERSION}
 Date...............: ${DATE}
 Uptime.............: ${UPTIME}
 Users connected....: ${USERS_ONLINE}
 CPU Usage..........: ${CPU_USAGE}%
 Memory Usage.......: ${MEM_USAGE}
 Disk Usage.........: ${DISK_USAGE}
${white}
 Web GUI (access through browser): http://${LOCAL_IP}
 Documentation and help..........: Access through Web GUI above

 Show directory listing, type....: ls
 Run a Python script, type.......: python3 ${light_blue}name_of_file${white}.py
 Stop a Python script, press.....: CTRL+C

 To bring up this screen, type...: help 
"
