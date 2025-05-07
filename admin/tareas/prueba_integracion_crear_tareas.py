from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import os

# Configuro el navegador para realizar las pruebas
driver = webdriver.Chrome()
driver.get("http://localhost/proyectoEscuela/login/index.php")  # Accedo a la página de inicio de sesión

# Creo una carpeta para guardar las capturas de pantalla
if not os.path.exists("Capturas de pantalla"):
    os.makedirs("Capturas de pantalla")

# Defino una función para tomar capturas de pantalla
def capturar_pantalla(nombre):
    driver.save_screenshot(f"Capturas de pantalla/{nombre}.png")

# Defino una función para verificar si el usuario fue redirigido correctamente
def verificar_redireccion(url_esperada):
    return url_esperada in driver.current_url

# Flujo 1: Inicio de sesión para usuarios autenticados
try:
    print("Iniciando sesión como usuario autenticado...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")  # Credenciales válidas
    driver.find_element(By.NAME, "password").send_keys("123")
    capturar_pantalla("flujo1_ingresando_datos_login")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin"))
    capturar_pantalla("flujo1_login_exitoso")
    print("Flujo 1: Inicio de sesión - PASÓ")
except Exception as e:
    capturar_pantalla("flujo1_error")
    print(f"Flujo 1: Inicio de sesión - FALLÓ: {e}")

# Flujo 2: Crear una nueva tarea
try:
    print("Probando creación de una nueva tarea...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "titulo")))

    # Lleno los campos del formulario
    driver.find_element(By.NAME, "titulo").send_keys("Tarea de prueba")
    driver.find_element(By.NAME, "descripcion").send_keys("Esta es una descripción de prueba para la tarea.")
    driver.execute_script("document.getElementsByName('fecha_entrega')[0].value = '2025-05-10'")  # Fecha en formato correcto
    driver.execute_script("document.getElementsByName('hora_entrega')[0].value = '23:59'")  # Hora en formato correcto
    driver.find_element(By.NAME, "id_materia").send_keys(Keys.DOWN)  # Selecciono la primera materia del dropdown
    capturar_pantalla("flujo2_formulario_completado")

    # Envío el formulario
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Tarea')]").click()
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin/tareas"))
    capturar_pantalla("flujo2_tarea_creada")
    print("Flujo 2: Creación de tarea - PASÓ")
except Exception as e:
    capturar_pantalla("flujo2_error")
    print(f"Flujo 2: Creación de tarea - FALLÓ: {e}")

# Flujo 3: Verificar que la tarea aparezca en la lista
try:
    print("Verificando que la tarea aparezca en la lista...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "tbody")))

    # Esperar a que las filas de la tabla estén presentes
    WebDriverWait(driver, 10).until(EC.presence_of_all_elements_located((By.XPATH, "//table[@id='example1']//tr")))

    # Busco la tarea recién creada en la tabla
    tareas = driver.find_elements(By.XPATH, "//table[@id='example1']//tr")
    tarea_encontrada = False
    for tarea in tareas:
        print(tarea.text)  # Imprime el texto de cada fila para depuración
        if "Tarea de prueba" in tarea.text:
            tarea_encontrada = True
            break

    capturar_pantalla("flujo3_verificar_tarea_lista")
    if tarea_encontrada:
        print("Flujo 3: Verificación de tarea en lista - PASÓ")
    else:
        print("Flujo 3: Verificación de tarea en lista - FALLÓ")
except Exception as e:
    capturar_pantalla("flujo3_error")
    print(f"Flujo 3: Verificación de tarea en lista - FALLÓ: {e}")

# Cierro el navegador después de realizar las pruebas
driver.quit()