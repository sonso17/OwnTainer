Insert into components (UserID,ComponentName,ComponentTypeID,Privacy) VALUES (12,'Processador1',1,'false')

SELECT components.UserID, components.Privacy, components.ComponentName, components.ComponentID, properties.PropertyID,properties.PropertyName, propertiesxcomponents.Valuee
FROM propertiesxcomponents
RIGHT JOIN components ON propertiesxcomponents.ComponentID =  components.ComponentID
LEFT JOIN properties ON propertiesxcomponents.PropertyID = properties.PropertyID
WHERE components.Privacy = 'true';