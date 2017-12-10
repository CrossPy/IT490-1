import pika

def callback(ch, method, properties, body):
	print(">> " + body)

if __name__ == "__main__":
	conn = pika.BlockingConnection(pika.ConnectionParameters('localhost'))
	ch = conn.channel()
	ch.basic_consume(callback, queue='hello', no_ack=True)
	ch.start_consuming()
	
