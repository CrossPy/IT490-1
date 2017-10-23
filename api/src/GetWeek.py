import base64
import requests
import datetime
import json
import pika

RABBIT_HOST = '192.168.1.110'
RABBIT_PORT = 5672
RABBIT_Q = 'backendQueue'
RABBIT_PASS = 'Password123'
RABBIT_USER = 'backend'
RABBIT_VH = 'backendHost'
RABBIT_EX = 'backendExchange'

API_USER = 'efiorentine'
API_PASS = 'Edhp1280!'

def getDailyData(sport, username, password, date):
	date = date.isoformat().replace("-","")

	try:
		response = requests.get(
			url="https://api.mysportsfeeds.com/v1.1/pull/"+sport+"/current/daily_game_schedule.json",
			params={
				"fordate": date
			},
			headers={
				"Authorization":"Basic " + base64.b64encode('{}:{}'.format(username, password).encode('utf-8')).decode('ascii')
			}
		)
		return json.loads(response.text)
	except requests.exceptions.RequestException:
		print('Request Failed.')
		
def getWeeklyData(sport, username, password):
	rtndata = []
	today = datetime.date.today()
	numdays = 7
	date_list = [today - datetime.timedelta(days=x) for x in range(0, numdays)]
	for day in date_list:
		rtndata.append(getDailyData(sport, username, password, day))
	
	return rtndata

def insertData(weekOfData):
	for day in weekOfData:
		print(day)
		for game in day['dailygameschedule']["gameentry"]:
			identifier =  game["id"]
			date = game["date"]
			time = game["time"]
			awayTeam = game["awayTeam"]["Name"]
			homeTeam = game["homeTeam"]["Name"]
			sendRequest(RABBIT_HOST, RABBIT_Q, RABBIT_USER, RABBIT_PASS, RABBIT_VH, RABBIT_EX, RABBIT_PORT, 'insert_game_data', identifier, date, time, awayTeam, homeTeam)

def sendRequest(rabbitServer, rabbitQ, rabbitUser, rabbitPass, rabbitVHost, rabbitEx, rabbitPort, reqType, identifier, date, time, awayTeam, homeTeam):
	json_encoded_data = json.dumps([reqType, identifier, date, time, awayTeam, homeTeam])
	creds = pika.PlainCredentials(rabbitUser, rabbitPass)
	connection = pika.BlockingConnection(pika.ConnectionParameters(rabbitServer, rabbitPort, rabbitVHost, creds))
	channel = connection.channel()
	channel.basic_publish(exchange=rabbitEx, routing_key=rabbitQ, body=json_encoded_data)

def main():
	try:
 		insertData(getWeeklyData('nfl', API_USER, API_PASS))
	except Exception as e:
		print(e)

if __name__ == "__main__":
	main()	
