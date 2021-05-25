import pyasn1.codec.der.encoder
import pyasn1.type.univ
import base64

def recover_key(p, q, e, output_file):
	def egcd(a, b):
	    x,y, u,v = 0,1, 1,0
	    while a != 0:
	        q, r = b//a, b%a
	        m, n = x-u*q, y-v*q
	        b,a, x,y, u,v = a,r, u,v, m,n
	    gcd = b
	    return gcd, x, y

	def modinv(a, m):
	    gcd, x, y = egcd(a, m)
	    if gcd != 1:
	        return None  
	    else:
	        return x % m

	def pempriv(n, e, d, p, q, dP, dQ, qInv):
	    template = '-----BEGIN RSA PRIVATE KEY-----\n{}-----END RSA PRIVATE KEY-----\n'
	    seq = pyasn1.type.univ.Sequence()
	    for x in [0, n, e, d, p, q, dP, dQ, qInv]:
	        seq.setComponentByPosition(len(seq), pyasn1.type.univ.Integer(x))
	    der = pyasn1.codec.der.encoder.encode(seq)
	    return template.format(base64.encodestring(der).decode('ascii'))

	n = p * q
	phi = (p -1)*(q-1)
	d = modinv(e, phi)
	dp = modinv(e,(p-1))
	dq = modinv(e,(q-1))
	qi = modinv(q,p)

	key = pempriv(n, e, d, p, q, dp, dq, qi)

	f = open(output_file,"w")
	f.write(key)
	f.close()

if __name__ == '__main__' :
    p = 16765581643689842519
    q = 17570511931207078421
    e = 65537
    outfile = 'prive_key.pem'
    recover_key(p, q, e, outfile)