# Autochase 🚗💻

![Status](https://img.shields.io/badge/Status-Conclu%C3%ADdo-brightgreen)
![Version](https://img.shields.io/badge/Version-1.0.0-blue)
![License](https://img.shields.io/badge/License-Academic-lightgrey)

**Autochase** é um sistema web do tipo marketplace automotivo, desenvolvido para facilitar a busca, anúncio e venda de veículos de pequeno e médio porte.

A plataforma foi projetada com foco em **usabilidade**, **segurança**, **organização de dados** e **padronização de informações automotivas**, atendendo tanto vendedores quanto compradores.

---

## 🧾 Sobre o Projeto

O Autochase foi desenvolvido como **Trabalho de Conclusão de Curso (TCC)** do curso Técnico em Desenvolvimento de Sistemas.

> **Instituição:** Instituto Federal Sul-Rio-Grandense – Câmpus Visconde da Graça  
> **Ano:** 2025  
> **Orientador:** Dr. Fernando Augusto Treptow Brod

### 🎯 Objetivos

**Objetivo Geral** Desenvolver um sistema web que funcione como um marketplace automotivo, permitindo a compra e venda de veículos de forma prática, segura e eficiente.

**Objetivos Específicos**
* Permitir o cadastro e gerenciamento de usuários.
* Possibilitar o cadastro detalhado de veículos.
* Disponibilizar anúncios com controle de status.
* Facilitar a busca de veículos por meio de filtros avançados.
* Padronizar dados automotivos (marca, modelo, combustível, cor, chassi).
* Garantir segurança no armazenamento de dados sensíveis.
* Aplicar boas práticas de modelagem de banco de dados.

---

## 🛠️ Tecnologias Utilizadas

O projeto foi construído utilizando uma arquitetura robusta e tecnologias consolidadas no mercado.

**Front-end** ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)

**Back-end & Banco de Dados** ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=flat-square&logo=mysql&logoColor=white)

**Modelagem** * Diagrama Entidade-Relacionamento (DER)
* UML (Casos de Uso)

---

## ✅ Funcionalidades (Requisitos Funcionais)

| Código | Funcionalidade | Descrição |
| :--- | :--- | :--- |
| **RF01** | Gerenciar Usuários | Cadastro, edição e autenticação de usuários. |
| **RF02** | Autenticação | Login com e-mail e senha criptografada. |
| **RF03** | Gerenciar Veículos | Cadastro, edição e exclusão de veículos. |
| **RF04** | Gerenciar Anúncios | Criação, edição, inativação e exclusão de anúncios. |
| **RF05** | Consulta de Veículos | Busca por marca, modelo, ano, valor e palavras-chave. |
| **RF06** | Upload de Imagens | Inclusão de múltiplas imagens nos anúncios. |
| **RF07** | Controle de Status | Controle de anúncios ativos, inativos e vendidos. |

### 🔒 Requisitos Não Funcionais

* **Segurança:** Criptografia de senhas e Controle de níveis de acesso (ADMIN / USUÁRIO).
* **Desempenho:** Respostas rápidas nas consultas ao banco de dados.
* **Usabilidade:** Interface intuitiva, responsiva e navegação simples para leigos.
* **Portabilidade:** Acesso via navegadores modernos em diferentes dispositivos.
* **Conformidade Legal:** Adequação à LGPD no tratamento de dados pessoais.

---

## 🗃️ Modelagem do Banco de Dados

O banco de dados segue o modelo relacional, com foco em normalização e integridade referencial.

**Principais Entidades:**
`usuario`, `anuncio`, `veiculo`, `marca`, `modelo`, `cor`, `combustivel`, `chassi`, `imagem`.

**Destaques da Modelagem:**
* ✅ Separação entre veículo e anúncio para melhor controle.
* ✅ Uso de tabelas de domínio para evitar redundância.
* ✅ Relacionamentos definidos por chaves estrangeiras.
* ✅ Controle de status via ENUM.
* ✅ Múltiplas imagens por anúncio.

---

## 🗓️ Cronograma de Execução

| Etapa | Jun | Jul | Ago | Set | Out | Nov | Dez |
| :--- | :-: | :-: | :-: | :-: | :-: | :-: | :-: |
| Levantamento de Requisitos | ✅ | | | | | | |
| Modelagem do Banco de Dados | | ✅ | | | | | |
| Desenvolvimento Backend | |  | ✅ | | | | |
| Desenvolvimento Frontend | | |  | ✅ | | | |
| Testes do Sistema | | | |  | ✅ | | |
| Finalização do TCC | | | | |  | ✅ | |
| Defesa do TCC | | | | | | |✅|

---

## 🔗 Documentação

* 📄 **[Relatório Completo do TCC (Google Docs)](https://docs.google.com/document/d/13U6gm1k4F6qcifSKi5TySDGWiLTYduYAomKqnvopJ1I/edit)**

### Licença
Este projeto possui finalidade exclusivamente acadêmica, seguindo as diretrizes institucionais do IFSul – Câmpus Visconde da Graça.

---

## 📫 Autores

<div align="center">

| [<img src="https://github.com/andreicuruja.png" width="120px;"/><br /><sub><b>Andrei Buss</b></sub>](https://github.com/andreicuruja)<br />💻 Front-end Developer | [<img src="https://github.com/OtavioDSP.png" width="120px;"/><br /><sub><b>Otávio Pacheco</b></sub>](https://github.com/OtavioDSP)<br />⚙️ Back-end Developer |
| :---: | :---: |

<br />
Feito com 💜 por Andrei Buss e Otávio Pacheco.

</div>
