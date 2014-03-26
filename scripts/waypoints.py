import sys
import csv

filename = sys.argv[1]

with open(filename) as fp:
  csv_reader = csv.DictReader(fp, delimiter=',', quotechar='"')
  
  for line in csv_reader:
    print "{coords: {\n"
    lat = line['lat']
    lon = line['lon']
    acc = 0
    print "  latitude: %s,\n  longitude: %s,\n  accuracy: %d\n}}," % (lat, lon, acc)