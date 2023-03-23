DROP DATABASE IF EXISTS OwnTainer;
CREATE DATABASE OwnTainer;
USE OwnTainer;

CREATE TABLE Users(
    UserID  INT NOT NULL AUTO_INCREMENT,
    FirstName VARCHAR(20),
    LastName VARCHAR(20),
    email VARCHAR(75) NOT NULL UNIQUE,
    passwd VARCHAR(50) NOT NULL,
    APIKEY VARCHAR(15) NOT NULL,
    PRIMARY KEY(UserID)
);

CREATE TABLE ComponentType(
    ComponentTypeID INT NOT NULL UNIQUE AUTO_INCREMENT,
    ComponentType VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY(ComponentTypeID)
);

CREATE TABLE Properties(
    PropertyID INT NOT NULL UNIQUE AUTO_INCREMENT,
    PropertyName VARCHAR(75) NOT NULL UNIQUE,
    UnitType VARCHAR(15),
    PRIMARY KEY(PropertyID)
);

CREATE TABLE Components(
    UserID INT NOT NULL,
    ComponentID INT NOT NULL AUTO_INCREMENT,
    ComponentName VARCHAR(40),
    ComponentTypeID INT NOT NULL,
    Privacy VARCHAR(5),
    PRIMARY KEY(ComponentID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (ComponentTypeID) REFERENCES ComponentType(ComponentTypeID)
);

CREATE TABLE ComponentTypeXProperties(
    PKCTXP INT NOT NULL AUTO_INCREMENT,
    ComponentTypeID INT NOT NULL,
    PropertyID INT NOT NULL,
    PRIMARY KEY(PKCTXP),
    FOREIGN KEY(ComponentTypeID) REFERENCES ComponentType(ComponentTypeID),
    FOREIGN KEY(PropertyID) REFERENCES Properties(PropertyID)
);

CREATE TABLE PropertiesXComponents(
    PKPXC INT NOT NULL AUTO_INCREMENT,
    PropertyID INT NOT NULL,
    ComponentID INT NOT NULL,
    Valuee VARCHAR(100),
    PRIMARY KEY(PKPXC),
    FOREIGN KEY(PropertyID) REFERENCES Properties(PropertyID),
    FOREIGN KEY(ComponentID) REFERENCES Components(ComponentID)
);


