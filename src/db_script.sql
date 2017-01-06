-- Table: public.customertype

-- DROP TABLE public.customertype;

CREATE TABLE public.customertype
(
  id integer NOT NULL DEFAULT nextval('"Customertype_Id_seq"'::regclass),
  type character(15),
  CONSTRAINT "Customertype_pkey" PRIMARY KEY (id),
  CONSTRAINT customertype_id_key UNIQUE (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.customertype
  OWNER TO postgres;

-- Table: public.services

-- DROP TABLE public.services;

CREATE TABLE public.services
(
  id integer NOT NULL DEFAULT nextval('"Services_Id_seq"'::regclass),
  name character varying(15) NOT NULL,
  CONSTRAINT "Services_pkey" PRIMARY KEY (id),
  CONSTRAINT services_id_key UNIQUE (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.services
  OWNER TO postgres;

-- Table: public.customers

-- DROP TABLE public.customers;

CREATE TABLE public.customers
(
  id integer NOT NULL DEFAULT nextval('"Customers_Id_seq"'::regclass),
  title character(4),
  firstname character varying(50),
  lastname character varying(50),
  customertype_id integer NOT NULL,
  queuetime  timestamp without time zone,
  service_id integer NOT NULL,
  CONSTRAINT "Customers_pkey" PRIMARY KEY (id),
  CONSTRAINT "Customertype_id" FOREIGN KEY (customertype_id)
      REFERENCES public.customertype ("Id") MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT "Service_id" FOREIGN KEY (service_id)
      REFERENCES public.services ("Id") MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT customers_id_key UNIQUE (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.customers
  OWNER TO postgres;

-- Index: public."fki_Customertype_id"

-- DROP INDEX public."fki_Customertype_id";

CREATE INDEX "fki_Customertype_id"
  ON public.customers
  USING btree
  (customertype_id);

-- Index: public."fki_Service_id"

-- DROP INDEX public."fki_Service_id";

CREATE INDEX "fki_Service_id"
  ON public.customers
  USING btree
  (service_id);

INSERT INTO customertype VALUES(1, 'Citizen');
INSERT INTO customertype VALUES(2, 'Organization');
INSERT INTO customertype VALUES(3, 'Anonymous');

INSERT INTO services VALUES(1, 'Hosting');
INSERT INTO services VALUES(2, 'Benefits');
INSERT INTO services VALUES(3, 'Council Tax');
INSERT INTO services VALUES(4, 'Fly-tipping');
INSERT INTO services VALUES(5, 'Missed Bin');