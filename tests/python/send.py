import pika

if __name__ == '__main__':
	conn = pika.BlockingConnection(pika.ConnectionParameters('localhost'))
	ch = conn.channel()
	while (1):
		msg = raw_input(">> ")
		ch.basic_publish(exchange='', routing_key='hello',body=msg)
		print("Sent >> " + msg)
	conn.close()
