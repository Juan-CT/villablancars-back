INSERT INTO marcas (nombre) VALUES 
('Alfa Romeo'),
('Audi'),
('BMW'),
('Chevrolet'),
('Citroen'),
('Cupra'),
('Dacia'),
('DS'),
('Fiat'),
('Ford'),
('Honda'),
('Hyundai'),
('Jaguar'),
('Jeep'),
('Kia'),
('Land-Rover'),
('Lexus'),
('Mazda'),
('Mercedes-Benz'),
('Mini'),
('Mitsubishi'),
('Nissan'),
('Opel'),
('Peugeot'),
('Porsche'),
('Renault'),
('Seat'),
('Skoda'),
('Smart'),
('Ssangyong'),
('Suzuki'),
('Tesla'),
('Toyota'),
('Volkswagen'),
('Volvo');

select * from marcas;

alter table marcas drop column created_at, drop column updated_at;

delete from marcas where nombre in ('Ssangyong', 'Jaguar', 'Smart', 'Land-Rover');