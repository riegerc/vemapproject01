/*
	Autor: Christian Riedler
*/
SELECT c.objectID as 'criteriaId', c.name as 'criteraName', sum(rm.mark)
FROM criteria c
	JOIN subcriteria sc
		ON c.objectID = sc.criteriaFID
	JOIN reviewsmark rm
		ON sc.objectID = rm.undercriteriaFID
GROUP BY c.objectID, c.name

SELECT MONTH(datetime) as 'month', count(objectID) as 'surveycount' FROM reviews
GROUP BY month;

SELECT MONTH('2019-02-05 08:59:09');