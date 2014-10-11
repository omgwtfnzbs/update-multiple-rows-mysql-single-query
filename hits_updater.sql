UPDATE nzb_details
	SET hits = CASE reqid
		WHEN '00vXd' THEN hits + 1
		WHEN '0dxe0' THEN hits + 1
		WHEN '0iMXk' THEN hits + 1
		WHEN '0KkdT' THEN hits + 2
		WHEN '0TgDs' THEN hits + 1
		WHEN '103997' THEN hits + 1
		WHEN '104706' THEN hits + 1
ELSE hits
END
WHERE reqid IN('00vXd', '0dxe0', '0iMXk', '0KkdT', '0TgDs', '103997', '104706');
