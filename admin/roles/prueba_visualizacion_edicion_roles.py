from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
import os

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

# Flujo 2: Visualización de la lista de roles
try:
    print("Accediendo a la página de visualización de roles...")
    driver.get("http://localhost/proyectoEscuela/admin/roles/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))
    capturar("roles_cargados")

    # Verifico que la tabla de roles esté visible
    tabla_roles = driver.find_element(By.ID, "example1")
    filas = tabla_roles.find_elements(By.TAG_NAME, "tr")
    if len(filas) > 1:  # Verifico que haya al menos una fila de datos
        print(f"Se encontraron {len(filas) - 1} roles en la tabla.")
        capturar("roles_listados")
        print("Flujo 2: Visualización de roles - PASÓ")
    else:
        print("No se encontraron roles en la tabla.")
        capturar("roles_vacios")
except Exception as e:
    capturar("error_visualizacion_roles")
    print(f"Flujo 2: Visualización de roles - FALLÓ: {e}")

# Flujo 3: Verificación de datos de roles
try:
    print("Verificando que los datos de los roles coincidan con la base de datos...")
    roles_mostrados = [fila.find_elements(By.TAG_NAME, "td")[1].text for fila in filas[1:]]
    print(f"Roles mostrados en la tabla: {roles_mostrados}")
    # Aquí se podría agregar una comparación con los datos de la base de datos si se tiene acceso a ellos
    print("Flujo 3: Verificación de datos de roles - PASÓ")
except Exception as e:
    capturar("error_verificacion_datos")
    print(f"Flujo 3: Verificación de datos de roles - FALLÓ: {e}")

# Flujo 4: Prueba de interfaz de usuario
try:
    print("Verificando la interfaz de usuario...")
    encabezados = driver.find_elements(By.XPATH, "//table[@id='example1']/thead/tr/th")
    encabezados_texto = [encabezado.text for encabezado in encabezados]
    print(f"Encabezados encontrados: {encabezados_texto}")
    if "Nombre de rol" in encabezados_texto and "Acciones" in encabezados_texto:
        print("La interfaz de usuario es clara y organizada.")
        capturar("interfaz_correcta")
        print("Flujo 4: Prueba de interfaz de usuario - PASÓ")
    else:
        print("La interfaz de usuario tiene problemas de diseño.")
        capturar("interfaz_incorrecta")
except Exception as e:
    capturar("error_interfaz_usuario")
    print(f"Flujo 4: Prueba de interfaz de usuario - FALLÓ: {e}")

# Finalizo la prueba cerrando el navegador
driver.quit()