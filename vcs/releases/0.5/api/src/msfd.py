from configparser import SafeConfigParser
from ohmysportsfeedspy import MySportsFeeds

#Init conf.ini
parse = SafeConfigParser()
parse.read('conf.ini')

#Grab consts from conf.ini
api_ver = parse.get('main','api_ver')
api_username = parse.get('main', 'api_username')
api_password = parse.get('main', 'api_password')
interval = parse.get('main', 'interval')
#Init MSF Connection
msf = MySportsFeeds(version=api_ver)
msf.authenticate(api_username,api_password)

def get_latest_data(sport, msf):
	#To-Do: Get all games in the next 14 days for given sport	
	rtdata = msf.msf_get_data(league=sport)

def main():
	if __name__ == '__main__':
		#Main service loop
		while(True):
			get_latest_data('nfl',msf)
			get_latest_data('nba',msf)
			get_latest_data('mlb',msf)
			time.sleep(interval)
main()
