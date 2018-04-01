#!/usr/bin/python
import os
import subprocess
import sys
import signal
def signal_handler(signal, frame):
  print("Use 'exit' to exit. If inside a function, enter information that will not be successful in any contacts search.\n")
signal.signal(signal.SIGINT, signal_handler)
print "SMS Gateway Shell v. 1.6"
print "Please use secure connections for this program."
username = raw_input("Enter the SMS Gateway username:\n")
password = raw_input("Enter the SMS Gateway password:\n")
print "Connecting . . . "
proc = subprocess.Popen("php /usr/bin/sms-shell/get_devices.php "+username+" "+password+" id_only", shell=True, stdout=subprocess.PIPE)
id = proc.stdout.read()
while True:
  directive = raw_input(username+">");
  if ( directive == "exit" ):
    sys.exit(0)
  elif ( directive == "send" ):
    message = raw_input("Message?\n")
    recipient = raw_input("Recipient? ")
    sendproc = subprocess.Popen("php /usr/bin/sms-shell/send_message.php "+username+" "+password+" "+id+" "+recipient+" \""+message+"\" tidy", shell=True, stdout=subprocess.PIPE)
    result = sendproc.stdout.read()
    print result
  elif ( directive == "read" ):
    messagesproc = subprocess.Popen("php /usr/bin/sms-shell/get_messages.php "+username+" "+password+" 1 tidy", shell=True, stdout=subprocess.PIPE)
    messages = messagesproc.stdout.read()
    print messages
  elif ( directive == "device" ):
    deviceproc = subprocess.Popen("php /usr/bin/sms-shell/get_devices.php "+username+" "+password+" tidy", shell=True, stdout=subprocess.PIPE)
    devices = deviceproc.stdout.read()
    print devices
  elif ( directive == "sendc" ):
    message = raw_input("Message?\n")
    recipient = raw_input("Recipient? (will attempt reg-ex search, case-sensitive)\n")
    sendproc = subprocess.Popen("php /usr/bin/sms-shell/send_message_contact.php "+username+" "+password+" "+id+" "+recipient+" \""+message+"\" tidy", shell=True, stdout=subprocess.PIPE)
    result = sendproc.stdout.read()
    print result
  elif ( directive == "readc" ):
    contact = raw_input("Contact? ")
    convoproc = subprocess.Popen("php /usr/bin/sms-shell/get_convo.php "+username+" "+password+" "+contact, shell=True, stdout=subprocess.PIPE)
    result = convoproc.stdout.read()
    print result
  elif ( directive == "search-contacts" ):
    contact = raw_input("Contact? ")
    contactproc = subprocess.Popen("grep \""+contact+"\" ~/"+username, shell=True, stdout=subprocess.PIPE)
    result = contactproc.stdout.read()
    print result
  elif ( directive == "exec" ):
    program = raw_input("Run? ")
    progproc = subprocess.Popen(program, shell=True, stdout=subprocess.PIPE)
    result = progproc.stdout.read()
    print result
  else:
    print "exit send read device sendc readc search-contacts exec"
