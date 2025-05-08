from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
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

# Flujo 1: Acceso a la funcionalidad de creación
try:
    print("Iniciando sesión como administrador...")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys("admin@admin.com")  # Credenciales válidas
    driver.find_element(By.NAME, "password").send_keys("123")
    capturar_pantalla("flujo1_ingresando_datos_login")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)

    # Verifico si el usuario fue redirigido correctamente al dashboard
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)
    capturar_pantalla("flujo1_login_exitoso")

    # Accedo a la funcionalidad de creación de materias
    driver.get("http://localhost/proyectoEscuela/admin/materias/create.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "nombre_materia")))
    capturar_pantalla("flujo1_acceso_creacion")
    print("Flujo 1: Acceso a la funcionalidad de creación - PASÓ")
except Exception as e:
    capturar_pantalla("flujo1_error")
    print(f"Flujo 1: Acceso a la funcionalidad de creación - FALLÓ: {e}")
    driver.quit()
    exit()

# Flujo 2: Validación de campos obligatorios
try:
    print("Probando validación de campos obligatorios...")
    # Intento enviar el formulario sin llenar los campos obligatorios
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Materia')]").click()

    # Verifico que la URL no cambie
    WebDriverWait(driver, 5).until(lambda d: "create.php" in d.current_url)
    capturar_pantalla("flujo2_validacion_campos")
    print("Flujo 2: Validación de campos obligatorios - PASÓ: El formulario no se envió.")
except Exception as e:
    capturar_pantalla("flujo2_error")
    print(f"Flujo 2: Validación de campos obligatorios - FALLÓ: {e}")

# Flujo 3: Creación exitosa de una materia
try:
    print("Probando creación exitosa de una materia...")
    
    # Lleno los campos obligatorios del formulario
    driver.find_element(By.NAME, "nombre_materia").send_keys("Materia de Prueba")
    driver.find_element(By.NAME, "descripcion").send_keys("Descripción breve de la materia.")

    # Capturo el estado del formulario antes de enviarlo
    capturar_pantalla("flujo3_formulario_completado")

    # Envío el formulario
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Materia')]").click()

    # Verifico que la redirección sea exitosa al listado de materias
    WebDriverWait(driver, 10).until(lambda d: "admin/materias" in d.current_url)
    capturar_pantalla("flujo3_materia_creada")
    print("Flujo 3: Creación exitosa de una materia - PASÓ")
except Exception as e:
    # Capturo cualquier error y lo registro
    capturar_pantalla("flujo3_error")
    print(f"Flujo 3: Creación exitosa de una materia - FALLÓ: {e}")


# Flujo 4: Permisos de creación
try:
    print("Probando permisos de creación...")
    driver.get("http://localhost/proyectoEscuela/login/logout.php")  # Cierro sesión del administrador
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "email")))

    # Inicio sesión con un usuario sin permisos
    driver.find_element(By.NAME, "email").send_keys("estudiante@gmail.com")  # Usuario sin permisos
    driver.find_element(By.NAME, "password").send_keys("123")
    driver.find_element(By.NAME, "password").send_keys(Keys.RETURN)
    WebDriverWait(driver, 10).until(lambda d: "admin" in d.current_url)

    # Intento acceder a la funcionalidad de creación de materias
    driver.get("http://localhost/proyectoEscuela/admin/materias/create.php")
    capturar_pantalla("flujo4_acceso_denegado")

    # Verifico si el acceso fue denegado
    if "home.php" in driver.current_url:
        print("Flujo 4: Permisos de creación - PASÓ: El usuario fue redirigido al home.")
    else:
        print("Flujo 4: Permisos de creación - FALLÓ: El usuario no fue redirigido correctamente.")
except Exception as e:
    capturar_pantalla("flujo4_error")
    print(f"Flujo 4: Permisos de creación - FALLÓ: {e}")

# Cierro el navegador después de realizar las pruebas
driver.quit()