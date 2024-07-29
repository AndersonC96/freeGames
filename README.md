# Free Games Viewer

## Descrição

O **Free Games Viewer** é uma aplicação web que permite aos usuários pesquisar e navegar por jogos gratuitos utilizando dados da FreeToGame API. Os usuários podem filtrar jogos por gênero, classificá-los por vários critérios e navegar através de páginas de resultados.

## Funcionalidades

- Pesquisa de jogos por nome.
- Filtro de jogos por gênero.
- Classificação de jogos por ordem alfabética, data de lançamento ou popularidade.
- Paginação dos resultados com botões de anterior e próximo.
- Visualização de informações detalhadas sobre cada jogo, incluindo título, descrição, gênero, desenvolvedor, publicador, data de lançamento e ícones de plataformas.

## Tecnologias Utilizadas

- **HTML**
- **CSS (Tailwind CSS)**
- **JavaScript**
- **PHP**
- **FreeToGame API**

## Instalação

1. Clone o repositório:
    ```sh
    git clone https://github.com/AndersonC96/freeGames.git
    ```
2. Navegue até o diretório do projeto:
    ```sh
    cd freeGames
    ```
3. Configure um servidor local:
    - Certifique-se de ter o PHP instalado.
    - Você pode usar ferramentas como XAMPP, WAMP ou MAMP para configurar um servidor local.
    - Coloque o diretório do projeto no diretório raiz do seu servidor (e.g., htdocs para XAMPP).

4. Inicie o servidor:
    - Para XAMPP, abra o Painel de Controle do XAMPP e inicie o servidor Apache.

5. Abra a aplicação:
    - No seu navegador web, navegue até `http://localhost/freeGames`.

## Uso

### Pesquisa de jogos:
- Insira o nome do jogo no campo de pesquisa e clique em "Search".

### Filtrar por gênero:
- Selecione um gênero no menu dropdown para filtrar os resultados.

### Classificar resultados:
- Escolha uma opção de classificação (Alfabética, Data de Lançamento, Popularidade) no menu dropdown.

### Navegar através das páginas:
- Use os botões "Previous" e "Next" para navegar pelas páginas de resultados.

## API

A aplicação utiliza a FreeToGame API para buscar dados sobre jogos gratuitos. Para mais informações sobre a API, visite a [documentação da FreeToGame API](https://www.freetogame.com/api-doc).

## Estrutura do Código

- **index.php**: O arquivo HTML principal contendo a estrutura e o JavaScript para buscar e exibir jogos.
- **api.php**: O script PHP que lida com requisições à API e retorna dados filtrados e classificados dos jogos.
- **img/**: Diretório contendo ícones de plataformas utilizados na aplicação.

## Personalização

Para personalizar a aplicação, você pode modificar os seguintes itens:

- **Estilos**: Ajuste as classes do Tailwind CSS em `index.php` para alterar a aparência da aplicação.
- **Requisições à API**: Modifique a lógica das requisições à API em `index.php` e `api.php` para buscar dados adicionais ou aplicar diferentes filtros e opções de classificação.

---