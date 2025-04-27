from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import mysql.connector
import time

# Configuración de Selenium
driver = webdriver.Chrome()  # Asegúrate de tener el controlador de Chrome instalado
driver.get("http://localhost/proyectoEscuela/login/index.php")  # URL de la página de inicio de sesión

# Configuración de la base de datos
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'sistemaescolar'
}

# Función para verificar si la tarea existe en la base de datos
def verificar_tarea_en_bd(titulo):
    connection = mysql.connector.connect(**db_config)
    cursor = connection.cursor()
    try:
        query = "SELECT * FROM tareas WHERE titulo = %s"
        cursor.execute(query, (titulo,))
        resultado = cursor.fetchone()
        return resultado is not None
    finally:
        cursor.close()
        connection.close()

# Inicio de sesión con usuario administrador
try:
    print("Intentando iniciar sesión como administrador...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "password").send_keys("123")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(EC.url_contains("admin"))
    print("Inicio de sesión como administrador - PASÓ")
except Exception as e:
    print(f"Inicio de sesión como administrador - FALLÓ: {e}")
    driver.quit()
    exit()

# Flujo 1: Creación válida
try:
    print("Probando la creación de una tarea válida...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    time.sleep(3)  # Pausa de 3 segundos

    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "id_materia")))
    select_materia = Select(driver.find_element(By.NAME, "id_materia"))
    select_materia.select_by_value("1")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "titulo").send_keys("Tarea de prueba válida")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "descripcion").send_keys("Descripción de la tarea de prueba válida")
    time.sleep(3)  # Pausa de 3 segundos
    driver.execute_script("document.getElementsByName('fecha_entrega')[0].value = '2025-04-30'")
    driver.execute_script("document.getElementsByName('hora_entrega')[0].value = '23:59'")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "hora_entrega").send_keys(Keys.RETURN)
    time.sleep(3)  # Pausa de 3 segundos

    WebDriverWait(driver, 10).until(EC.url_contains("index.php"))
    print("Flujo 1: Creación válida - PASÓ")

    print("Verificando en la base de datos si la tarea fue creada...")
    if verificar_tarea_en_bd("Tarea de prueba válida"):
        print("Flujo 3: Verificación en base de datos - PASÓ")
    else:
        print("Flujo 3: Verificación en base de datos - FALLÓ")
except Exception as e:
    print(f"Flujo 1: Creación válida - FALLÓ: {e}")

# Flujo 2: Creación fallida
try:
    print("Probando la creación de una tarea con datos inválidos...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    time.sleep(3)  # Pausa de 3 segundos

    select_materia = Select(driver.find_element(By.NAME, "id_materia"))
    select_materia.select_by_value("1")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "titulo").send_keys("")  # Dejo el título vacío
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "descripcion").send_keys("Descripción inválida")
    time.sleep(3)  # Pausa de 3 segundos
    driver.execute_script("document.getElementsByName('fecha_entrega')[0].value = '2025-04-30'")
    driver.execute_script("document.getElementsByName('hora_entrega')[0].value = '23:59'")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "hora_entrega").send_keys(Keys.RETURN)
    time.sleep(3)  # Pausa de 3 segundos

    if "create.php" in driver.current_url:
        print("Flujo 2: Creación fallida - PASÓ")
    else:
        print("Flujo 2: Creación fallida - FALLÓ")
except Exception as e:
    print(f"Flujo 2: Creación fallida - FALLÓ: {e}")

# Flujo 4: Verificación de autenticación con usuario estudiante
try:
    print("Probando la autenticación con un usuario estudiante...")
    driver.get("http://localhost/proyectoEscuela/login/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("estudiante@gmail.com")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "password").send_keys("123")
    time.sleep(3)  # Pausa de 3 segundos
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(EC.url_contains("admin"))
    print("Inicio de sesión con estudiante - PASÓ")

    print("Intentando acceder a la página de creación de tareas...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/create.php")
    time.sleep(3)  # Pausa de 3 segundos

    if "home.php" in driver.current_url or "acceso_denegado.php" in driver.current_url:
        print("Flujo 4: Verificación de autenticación con estudiante - PASÓ")
    else:
        print("Flujo 4: Verificación de autenticación con estudiante - FALLÓ")
except Exception as e:
    print(f"Flujo 4: Verificación de autenticación con estudiante - FALLÓ: {e}")

# Cerrar el navegador
driver.quit()