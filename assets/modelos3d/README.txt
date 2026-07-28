Modelos 3D reales para la Galeria 3D de Desastres (views/desastres/galeria.php).

assets/js/disaster3d.js carga estos archivos con GLTFLoader. Si un slug no
tiene ningun .glb (o falla la carga), se usa automaticamente la escena
procedural de respaldo -- no hay que tocar codigo para que la galeria
funcione, esto es solo para mejorar la calidad visual cuando haya un modelo
real disponible.

Archivos actuales (ver el mapa MODEL_FILES en disaster3d.js):
  volcan.glb                                    (usado para "volcanes")
  Volcano by Poly by Google - ehL08wrtLCN.glb   (queda en la carpeta pero SIN usar)
  deslizamiento1.glb
  deslizamiento2.glb
  deslizamiento3.glb
  deslizamiento4.glb

Cuando un slug tiene varios archivos (como "deslizamientos" con 4), cada vez
que se monta la escena se elige uno al azar, para variar el diorama.

Para agregar un modelo a otra categoria (sismos, tsunamis, inundaciones,
incendios-forestales, tormentas-tropicales, sequias, lahares,
tormentas-electricas, erosion-costera):

1. Descarga un .glb con licencia libre (CC0 o CC-BY), por ejemplo de
   https://poly.pizza
2. Colocalo en esta carpeta.
3. Agrega su nombre de archivo a MODEL_FILES en assets/js/disaster3d.js,
   bajo la clave del slug correspondiente (o simplemente llamalo
   "<slug>.glb" -- ese es el nombre que se intenta por defecto si el slug
   no aparece en MODEL_FILES).
4. Si el modelo tiene licencia CC-BY, anota el autor en el array $modelos
   de galeria.php (campo 'autor', si se agrega) para dar el credito.
