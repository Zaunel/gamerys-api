# gamerys-api

# Obtener todos los juegos
http://localhost/gamerys-api/api/juegos

# Obtener juego por id
http://localhost/gamerys-api/api/juego/:ID

# Para agregar un juego 
http://localhost/gamerys-api/api/juegos

# Para modificar un juego
http://localhost/gamerys-api/api/juego/:ID

# Para eliminar un juego
http://localhost/gamerys-api/api/juego/:ID

# Para filtrar juegos por categorias
:Categorias = "Accion", "Terror", "Aventura", "Carreras", "FPS", "MMO RPG". (Respetar mayúsculas)
http://localhost/gamerys-api/api/juegos?categoria=:Categoria

# Para ordernar por columna ascendente o descendente 
:Columna = "precio", "juego"
:Order = "asc", "desc" 
http://localhost/gamerys-api/api/juegos?columna=:Columna&order=:Order