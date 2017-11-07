#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Liste
#------------------------------------------------------------

CREATE TABLE liste(
        id           int (11) Auto_increment  NOT NULL ,
        titre        Varchar (100) NOT NULL ,
        description  Varchar (500) NOT NULL ,
        date_limite  Date NOT NULL ,
        destinataire Varchar (100) NOT NULL ,
        for_him      Bool NOT NULL ,
        id_user      Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Item
#------------------------------------------------------------

CREATE TABLE item(
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

CREATE TABLE user(
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

CREATE TABLE message(
        id          int (11) Auto_increment  NOT NULL ,
        auteur      Varchar (250) NOT NULL ,
        description Varchar (500) NOT NULL ,
        type        Bool NOT NULL ,
        date_create Date NOT NULL ,
        id_liste    Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: contenir
#------------------------------------------------------------

CREATE TABLE contenir(
        reserver   Bool NOT NULL ,
        reserviste Varchar (250) ,
        id         Int NOT NULL ,
        id_item    Int NOT NULL ,
        PRIMARY KEY (id ,id_Item )
)ENGINE=InnoDB;

ALTER TABLE liste ADD CONSTRAINT FK_liste_id_user FOREIGN KEY (id_user) REFERENCES user(id);
ALTER TABLE message ADD CONSTRAINT FK_message_id_liste FOREIGN KEY (id_liste) REFERENCES liste(id);
ALTER TABLE contenir ADD CONSTRAINT FK_contenir_id FOREIGN KEY (id) REFERENCES liste(id);
ALTER TABLE contenir ADD CONSTRAINT FK_contenir_id_item FOREIGN KEY (id_item) REFERENCES item(id);