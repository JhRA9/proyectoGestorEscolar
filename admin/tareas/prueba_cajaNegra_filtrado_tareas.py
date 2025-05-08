from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os
from selenium.webdriver.common.keys import Keys

# Configuración inicial del navegador
driver = webdriver.Chrome()
driver.maximize_window()
driver.get("http://localhost/proyectoEscuela/login/index.php")

# Crear carpeta para capturas de pantalla
if not os.path.exists("Capturas de pantalla"):
    os.makedirs("Capturas de pantalla")

# Función para capturar pantallas
def capturar(nombre):
    driver.save_screenshot(f"Capturas de pantalla/{nombre}.png")

# Flujo 1: Inicio de sesión como administrador
try:
    print("Iniciando sesión como administrador...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")
    driver.find_element(By.NAME, "password").send_keys("123")
    capturar("login_datos_ingresados")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar("login_exitoso")
    print("Inicio de sesión completado con éxito.")
except Exception as e:
    capturar("login_error")
    print(f"Error durante el inicio de sesión: {e}")
    driver.quit()
    exit()

# Flujo 2: Filtrado de tareas por estado
try:
    print("Accediendo a la página de tareas...")
    driver.get("http://localhost/proyectoEscuela/admin/tareas/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))
    capturar("tareas_cargadas")

    # Filtrar tareas por estado "pendiente"
    print("Filtrando tareas por estado 'pendiente'...")
    boton_estado = driver.find_element(By.ID, "btn-estado")
    boton_estado.click()
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))
    capturar("tareas_filtradas_pendiente")

    # Verificar que las tareas mostradas tienen el estado "pendiente"
    filas = driver.find_elements(By.XPATH, "//table[@id='example1']/tbody/tr")
    tareas_pendientes = [fila.find_elements(By.TAG_NAME, "td")[5].text for fila in filas]
    if all(estado == "pendiente" for estado in tareas_pendientes):
        print("Flujo 2: Filtrado por estado 'pendiente' - PASÓ")
    else:
        print("Flujo 2: Filtrado por estado 'pendiente' - FALLÓ")
except Exception as e:
    capturar("error_filtrado_estado")
    print(f"Flujo 2: Filtrado por estado 'pendiente' - FALLÓ: {e}")

# Flujo 3: Validación de datos al filtrar
try:
    print("Validando datos al filtrar...")
    # Intentar filtrar con un estado inexistente
    driver.get("http://localhost/proyectoEscuela/config/controllers/tareas/list.php?order=estado_inexistente")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, "body")))
    capturar("estado_inexistente")
    mensaje_error = driver.find_element(By.TAG_NAME, "body").text
    if "No hay tareas disponibles con este estado" in mensaje_error:
        print("Flujo 3: Validación de datos al filtrar - PASÓ")
    else:
        print("Flujo 3: Validación de datos al filtrar - FALLÓ")
except Exception as e:
    capturar("error_validacion_datos")
    print(f"Flujo 3: Validación de datos al filtrar - FALLÓ: {e}")

# Finalizo la prueba cerrando el navegador
driver.quit()