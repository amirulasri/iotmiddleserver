<?php
require_once('vendor/autoload.php');

// Connect to the database
$host = 'localhost';
$dbuser = 'iotcontroller';
$dbpass = 'K5u[6_BPicVJetgC';
$dbname = 'iotcontroller';
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAkkp760k/oz60rz9+922x/NCvW1OaUgR181Is8XmEq/N03iu4
e5wlOTE3oPE6XzQXBCOd30pTkZkVTivxhOIeS8titZJtvlBHMOUaiyoRAoMPARHG
6rKv38yCeRhJj2T8RiXB3IfZc9cYO/W96KEgKBBBZq2RkqWMZaSK1vwxD9/YoOmJ
MdT9aOZRTPq5/7wlm1ccpoay3LBLvLDi+/k+ekI4yj8QUZUL397r9i99I+/3bJSK
kEgykeKP1yEyfHR0H/kcU/fx5++FlA6sD9kEPeQewMiM/XlsfNzWZuuFycmSIAbE
WEZZT6T1gch1ipZ70wil94RGYM3C86TmHI/LvQIDAQABAoIBAGwH/z0AybL24p2s
KUn1QwRs46JwubypuKToYXIth/Enh31uEf2OkNqMYwVCPxYBNKIE31f+3nnd76Lb
xq6YAUF9v7ZQnSR2yivsdE6i0Q7m09S5WQkGzeRadVuRuPjg3X+78E64L7hg9m+J
CSZanpGXd4So1qDSCj0hZrpeYKjUSnN07VaEd1x74bXzjI9XeAvfz8hpboNOfewi
V2FA/5uhbustyY70d4lYOzfnfFu/XRU268sirsDKiSXumsJVgxnzxgeQsll4v5bw
F985yKw1ATVXwbqhvAukoqVoxOhQ26owg1fAQJVrvzqyUxOXd4ojOHdeATERyJHl
iBI8Pm0CgYEAyNXRLozc9DqyHp8YDFXbkQ3XkI6vdcuYeCeiPAa3Depclt6s+FMo
SWFXIsnwqbmwdh6cQ2lx8/uQGmPVSFUCCCgJ2cQRIknToDxc9cEoaiFdv8v+9KJG
lv8qR2HYZtys/IIfI9OdaBDdySoHlAWoRuqsj1I2IbNSni5wIK+OxOcCgYEAunlD
ZYHB1YndphU+GHX7IyGz2jrMapyJfOSrW9JXCr5YOSAAqc123ZPy/KJtRw9ac32L
WXgf7HbB8/V5eblsE8XWbki15g94MuO3aPd4wqlTIkGifoEFnXDJjQvsKU3OdnHu
eWZ8KLKaL+kxYuRxD0jxiYQ6G9E0/r1rWWtEcbsCgYBJng7yiFIJ+GYIUXsIMoSs
lC1bYOIyRLIcATM326JIKItOBkvTLvBKjbLaHrnoDRgBBFF1aHaL37+/3K52uCpp
gPuzZmp9biBz0QymTOqalKZ/wrAvTjif6uK9jcE8W1HRsYTmphBB8ETME2r5uGUp
saYVVyZejhQPxaf2Y0PrKwKBgQCZ86Gz/VPlk6QeCW2xzj4f/CQ7qM25uzE7nqLm
9RqNsSavSv+hMRPQzeQPtZ4Yy9E2hlD09dsNY+KvIlw/JdnX3T8y3+7lWKI5CY4U
KDRYKmmLX7rjTGwxVrvgKha45xbs7RUgv38ELqhjo9f1OHsrTmKz0SoUaz2gjwxA
z/G7HwKBgQCqIOnFccOBpqAKPhKTUModANk/caiQFLfzhaN4PoIKLs3D37EuP+7U
WV686jE6YrTpfuXhA9iLdT9JelgiLo1w90EYrFka9RRQ0s7leN1OkhDLwLA1mvpv
Np7BC55OOZa2zXnx1hzYhrd6x8LnAWgQhCVd4OAywYZX3ykwvWMDzg==
-----END RSA PRIVATE KEY-----
EOD;

$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkkp760k/oz60rz9+922x
/NCvW1OaUgR181Is8XmEq/N03iu4e5wlOTE3oPE6XzQXBCOd30pTkZkVTivxhOIe
S8titZJtvlBHMOUaiyoRAoMPARHG6rKv38yCeRhJj2T8RiXB3IfZc9cYO/W96KEg
KBBBZq2RkqWMZaSK1vwxD9/YoOmJMdT9aOZRTPq5/7wlm1ccpoay3LBLvLDi+/k+
ekI4yj8QUZUL397r9i99I+/3bJSKkEgykeKP1yEyfHR0H/kcU/fx5++FlA6sD9kE
PeQewMiM/XlsfNzWZuuFycmSIAbEWEZZT6T1gch1ipZ70wil94RGYM3C86TmHI/L
vQIDAQAB
-----END PUBLIC KEY-----
EOD;
