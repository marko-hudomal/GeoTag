
CREATE TABLE [Destination]
( 
	[idDest]             uniqueidentifier  NOT NULL ,
	[name]               varchar(20)  NOT NULL ,
	[longitude]          double precision  NOT NULL ,
	[latitude]           double precision  NOT NULL ,
	[pending]            bit  NOT NULL ,
	[country]            varchar(20)  NOT NULL 
)
go

ALTER TABLE [Destination]
	ADD CONSTRAINT [XPKDestination] PRIMARY KEY  CLUSTERED ([idDest] ASC)
go

CREATE TABLE [Image]
( 
	[idImg]              uniqueidentifier  NOT NULL ,
	[img]                varbinary  NOT NULL 
)
go

ALTER TABLE [Image]
	ADD CONSTRAINT [XPKImage] PRIMARY KEY  CLUSTERED ([idImg] ASC)
go

CREATE TABLE [Request]
( 
	[idReq]              uniqueidentifier  NOT NULL ,
	[type]               varchar(20)  NOT NULL ,
	[username]           varchar(20)  NULL ,
	[idRev]              uniqueidentifier  NULL ,
	[idDest]             uniqueidentifier  NULL 
)
go

ALTER TABLE [Request]
	ADD CONSTRAINT [XPKRequest] PRIMARY KEY  CLUSTERED ([idReq] ASC)
go

CREATE TABLE [Review]
( 
	[idRev]              uniqueidentifier  NOT NULL ,
	[content]            varchar(200)  NOT NULL ,
	[upCount]            integer  NOT NULL ,
	[downCount]          integer  NOT NULL ,
	[date]               datetime  NOT NULL ,
	[username]           varchar(20)  NOT NULL ,
	[idImg]              uniqueidentifier  NULL ,
	[idDest]             uniqueidentifier  NULL 
)
go

ALTER TABLE [Review]
	ADD CONSTRAINT [XPKReview] PRIMARY KEY  CLUSTERED ([idRev] ASC)
go

CREATE TABLE [Statistic]
( 
	[date]               datetime  NOT NULL ,
	[userCount]          integer  NOT NULL ,
	[reviewCount]        integer  NOT NULL ,
	[destinationCount]   integer  NOT NULL ,
	[positiveVoteCount]  integer  NOT NULL ,
	[negativeVoteCount]  integer  NOT NULL 
)
go

ALTER TABLE [Statistic]
	ADD CONSTRAINT [XPKStatistic] PRIMARY KEY  CLUSTERED ([date] ASC)
go

CREATE TABLE [User]
( 
	[username]           varchar(20)  NOT NULL ,
	[email]              varchar(40)  NOT NULL ,
	[status]             varchar(20)  NOT NULL ,
	[password]           varchar(20)  NOT NULL ,
	[firstname]          varchar(20)  NOT NULL ,
	[lastname]           varchar(20)  NOT NULL ,
	[gender]             varchar(10)  NOT NULL ,
	[idImg]              uniqueidentifier  NULL 
)
go

ALTER TABLE [User]
	ADD CONSTRAINT [XPKUser] PRIMARY KEY  CLUSTERED ([username] ASC)
go

CREATE TABLE [Vote]
( 
	[type]               bit  NOT NULL ,
	[username]           varchar(20)  NOT NULL ,
	[idRev]              uniqueidentifier  NOT NULL 
)
go

ALTER TABLE [Vote]
	ADD CONSTRAINT [XPKVote] PRIMARY KEY  CLUSTERED ([username] ASC,[idRev] ASC)
go


ALTER TABLE [Request]
	ADD CONSTRAINT [R_7] FOREIGN KEY ([username]) REFERENCES [User]([username])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Request]
	ADD CONSTRAINT [R_8] FOREIGN KEY ([idRev]) REFERENCES [Review]([idRev])
		ON DELETE CASCADE
go

ALTER TABLE [Request]
	ADD CONSTRAINT [R_9] FOREIGN KEY ([idDest]) REFERENCES [Destination]([idDest])
		ON DELETE CASCADE
go


ALTER TABLE [Review]
	ADD CONSTRAINT [R_4] FOREIGN KEY ([idImg]) REFERENCES [Image]([idImg])
go

ALTER TABLE [Review]
	ADD CONSTRAINT [R_10] FOREIGN KEY ([idDest]) REFERENCES [Destination]([idDest])
		ON DELETE CASCADE
go

ALTER TABLE [Review]
	ADD CONSTRAINT [R_2] FOREIGN KEY ([username]) REFERENCES [User]([username])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [User]
	ADD CONSTRAINT [R_3] FOREIGN KEY ([idImg]) REFERENCES [Image]([idImg])
go


ALTER TABLE [Vote]
	ADD CONSTRAINT [R_5] FOREIGN KEY ([username]) REFERENCES [User]([username])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Vote]
	ADD CONSTRAINT [R_6] FOREIGN KEY ([idRev]) REFERENCES [Review]([idRev])
		ON DELETE CASCADE
go
