-- alter database DEFAULT CHARACTER SET='UTF8' DEFAULT COLLATE ='utf8_general_ci';
create table busstops (
  id  int auto_increment,
  name  varchar(50),
  lat  float,
  lon  float,
  constraint pk_busstops primary key(id)
)ENGINE=InnoDB;

CREATE INDEX idx_busstops_name ON busstops (name(10));
CREATE INDEX idx_busstops_lat ON busstops (lat);
CREATE INDEX idx_busstops_lon ON busstops (lon);

create table routes (
  id  int auto_increment,
  name	varchar(50),
  constraint pk_routes primary key(id)
)ENGINE=InnoDB;

create table loggers (
  id int auto_increment,
  name  varchar(30) unique,
  pwhash  varchar(40),
  email  varchar(50),
  active  varchar(1),
  constraint pk_loggers primary key(id)
)ENGINE=InnoDB;

create table routepoints (
  id  int auto_increment,
  routeid  int,
  busstopid  int,
  stopnr  int,
  stoptime  time,
  constraint un_stopnr_routeid unique (routeid,stopnr),
  constraint pk_routepoints primary key(id),
  constraint fk_routepoints_routes foreign key(routeid) references routes(id),
  constraint fk_routepoints_busstops foreign key(busstopid) references busstops(id)
)ENGINE=InnoDB;


create table drivelogs (
  id  int auto_increment,
  routeid  int,
  lat  float,
  lon  float,
  logtime  datetime,
  loggerid int,
  constraint pk_drivelogs primary key(id),
  constraint fk_drivelogs_routes foreign key(routeid) references routes(id),
  constraint fk_drivelogs_loggers foreign key(loggerid) references loggers(id)
)ENGINE=InnoDB;

CREATE INDEX idx_drivelogs_logtime ON drivelogs (logtime);

create table routelogs (
  id  int auto_increment,
  routepointid    int,
  logtime  datetime,
  lat float,
  lon float,
  loggerid int,
  constraint pk_routelogs primary key(id),
  constraint fk_routelogs_routepoints foreign key(routepointid) references routepoints(id)
)ENGINE=InnoDB;

CREATE INDEX idx_routelogs_logtime ON routelogs (logtime);

create table admins (
  id int auto_increment,
  name  varchar(30) unique,
  pwhash  varchar(40),
  email  varchar(50),
  active  varchar(1),
  constraint pk_admins primary key(id)
)ENGINE=InnoDB;


create view routestations as
select rp.id as routepointid,
       rp.stopnr as stopnr,
       rp.stoptime as stoptime,
       rp.routeid as routeid,
       bs.name  as name,
       bs.lat  as lat,
       bs.lon  as lon
from routepoints  rp,busstops bs
where rp.busstopid=bs.id 
order by rp.routeid,rp.stopnr;

create view arrivelogs as
select rp.routeid as routeid,
       rp.id as routepointid,
       rp.stoptime as stoptime,
       rp.stopnr  as stopnr,
       rl.logtime as logtime,
       bs.name  as name,
       bs.lat as lat,
       bs.lon as lon
from routelogs rl,routepoints rp,busstops bs
where  rl.routepointid=rp.id and rp.busstopid=bs.id
order by rp.routeid,rp.stopnr;
