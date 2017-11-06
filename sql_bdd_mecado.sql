#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Liste
#------------------------------------------------------------

CREATE TABLE Liste(
        id           int (11) Auto_increment  NOT NULL ,
        titre        Varchar (100) NOT NULL ,
        description  Varchar (500) NOT NULL ,
        date_limite  Date NOT NULL ,
        destinataire Varchar (100) NOT NULL ,
        id_User      Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Item
#------------------------------------------------------------

CREATE TABLE Item(
        id          int (11) Auto_increment  NOT NULL ,
        nom         Varchar (250) NOT NULL ,
        description Varchar (500) NOT NULL ,
        tarif       Float NOT NULL ,
        url         Varchar (500) ,
        image       Varchar (500) ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: User
#------------------------------------------------------------

CREATE TABLE User(
        id     int (11) Auto_increment  NOT NULL ,
        nom    Varchar (250) ,
        prenom Varchar (250) ,
        mail   Varchar (250) NOT NULL ,
        mdp    Varchar (250) NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Message
#------------------------------------------------------------

CREATE TABLE Message(
        id          int (11) Auto_increment  NOT NULL ,
        auteur      Varchar (250) NOT NULL ,
        description Varchar (500) NOT NULL ,
        type        Bool NOT NULL ,
        date_create Date NOT NULL ,
        id_Liste    Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: contenir
#------------------------------------------------------------

CREATE TABLE contenir(
        reserver   Bool NOT NULL ,
        reserviste Varchar (250) ,
        id         Int NOT NULL ,
        id_Item    Int NOT NULL ,
        PRIMARY KEY (id ,id_Item )
)ENGINE=InnoDB;

ALTER TABLE Liste ADD CONSTRAINT FK_Liste_id_User FOREIGN KEY (id_User) REFERENCES User(id);
ALTER TABLE Message ADD CONSTRAINT FK_Message_id_Liste FOREIGN KEY (id_Liste) REFERENCES Liste(id);
ALTER TABLE contenir ADD CONSTRAINT FK_contenir_id_Liste FOREIGN KEY (id_Liste) REFERENCES Liste(id);
ALTER TABLE contenir ADD CONSTRAINT FK_contenir_id_Item FOREIGN KEY (id_Item) REFERENCES Item(id);
