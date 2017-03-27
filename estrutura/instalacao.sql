CREATE TABLE plugins.tomadorsuprimento (
	sequencial integer,
	orgao integer,
	unidade integer,
	numcgm integer,
	ativo boolean);

CREATE SEQUENCE plugins.tomadorsuprimento_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE plugins.empauttomador (
	sequencial integer, 
	autorizacaoempenho integer, 
	tomadorsuprimento integer);

CREATE SEQUENCE plugins.empauttomador_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE plugins.empprestaaprovacao (
	sequencial integer,
	emppresta integer,
	aprovado boolean
);

CREATE SEQUENCE plugins.empprestaaprovacao_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;