INSERT INTO carrocerias (nombre) VALUES 
('Berlina'),
('Familiar'),
('Coupé'),
('SUV'),
('Monovolumen'),
('Cabrio'),
('Pick Up');

select * from carrocerias;

alter table carrocerias drop column created_at, drop column updated_at;