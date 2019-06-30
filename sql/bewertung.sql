/*
	Autor: Christian Riedler
*/
SELECT c.objectID as 'criteriaId', c.name as 'criteraName', MONTH(rm.datetime) as 'month',sum(rm.mark) as 'sum'
			FROM criteria c
				JOIN subcriteria sc
					ON c.objectID = sc.criteriaFID
				JOIN reviewsmark rm
					ON sc.objectID = rm.undercriteriaFID
				JOIN reviews r
					ON rm.reviewsFID=r.objectID
				WHERE r.supplierUserFid=12
			GROUP BY c.objectID, c.name, month

SELECT MONTH(datetime) as 'month', count(objectID) as 'surveycount' FROM reviews
GROUP BY month;

SELECT MONTH('2019-02-05 08:59:09');

			