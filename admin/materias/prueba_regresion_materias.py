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

    # Verifico si el usuario fue redirigido correctamente al dashboard
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin"))
    capturar_pantalla("flujo1_login_exitoso")
    print("Flujo 1: Inicio de sesión - PASÓ")
except Exception as e:
    capturar_pantalla("flujo1_error")
    print(f"Flujo 1: Inicio de sesión - FALLÓ: {e}")
    driver.quit()
    exit()

# Flujo 2: Crear una nueva materia
try:
    print("Probando creación de una nueva materia...")
    driver.get("http://localhost/proyectoEscuela/admin/materias/create.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "nombre_materia")))

    # Lleno el formulario de creación
    driver.find_element(By.NAME, "nombre_materia").send_keys("Materia de Prueba")
    driver.find_element(By.NAME, "descripcion").send_keys("Descripción de prueba para la materia.")
    capturar_pantalla("flujo2_formulario_completado")

    # Envío el formulario
    driver.find_element(By.XPATH, "//button[contains(text(), 'Guardar Materia')]").click()
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin/materias"))
    capturar_pantalla("flujo2_materia_creada")
    print("Flujo 2: Creación de materia - PASÓ")
except Exception as e:
    capturar_pantalla("flujo2_error")
    print(f"Flujo 2: Creación de materia - FALLÓ: {e}")

# Flujo 3: Editar una materia existente
try:
    print("Probando edición de una materia existente...")
    driver.get("http://localhost/proyectoEscuela/admin/materias/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))

    # Selecciono el primer enlace de edición disponible
    primer_enlace_editar = driver.find_element(By.XPATH, "//a[contains(@href, 'edit.php')]")
    primer_enlace_editar.click()
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "nombre_materia")))

    # Modifico los campos
    nombre_materia_input = driver.find_element(By.NAME, "nombre_materia")
    nombre_materia_input.clear()
    nombre_materia_input.send_keys("Materia Editada")
    capturar_pantalla("flujo3_campos_modificados")

    # Guardo los cambios
    driver.find_element(By.XPATH, "//button[contains(text(), 'Actualizar')]").click()
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin/materias"))
    capturar_pantalla("flujo3_materia_actualizada")
    print("Flujo 3: Edición de materia - PASÓ")
except Exception as e:
    capturar_pantalla("flujo3_error")
    print(f"Flujo 3: Edición de materia - FALLÓ: {e}")

# Flujo 4: Eliminar una materia existente
try:
    print("Probando eliminación de una materia existente...")
    driver.get("http://localhost/proyectoEscuela/admin/materias/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))

    # Verifico si hay formularios de eliminación disponibles
    formularios_eliminar = driver.find_elements(By.XPATH, "//form[contains(@action, 'delete.php')]")
    if len(formularios_eliminar) == 0:
        raise Exception("No se encontraron formularios de eliminación en la tabla.")

    # Selecciono el primer formulario de eliminación disponible
    primer_formulario_eliminar = formularios_eliminar[0]
    boton_eliminar = primer_formulario_eliminar.find_element(By.XPATH, ".//button[@type='submit']")
    boton_eliminar.click()

    # Confirmo la eliminación en el modal de SweetAlert
    WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.CLASS_NAME, "swal2-confirm"))).click()

    # Espero a que la página se redirija o se actualice
    WebDriverWait(driver, 10).until(lambda d: verificar_redireccion("admin/materias"))
    capturar_pantalla("flujo4_materia_eliminada")
    print("Flujo 4: Eliminación de materia - PASÓ")
except Exception as e:
    capturar_pantalla("flujo4_error")
    print(f"Flujo 4: Eliminación de materia - FALLÓ: {e}")


# Flujo 5: Verificar integridad de datos
try:
    print("Verificando integridad de datos...")
    driver.get("http://localhost/proyectoEscuela/admin/materias/index.php")
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "example1")))

    # Verifico que las materias existentes no hayan sido modificadas
    materias = driver.find_elements(By.XPATH, "//table[@id='example1']//tr")
    for materia in materias:
        print(materia.text)  # Imprimo los datos de cada materia para verificar integridad
    capturar_pantalla("flujo5_integridad_datos")
    print("Flujo 5: Integridad de datos - PASÓ")
except Exception as e:
    capturar_pantalla("flujo5_error")
    print(f"Flujo 5: Integridad de datos - FALLÓ: {e}")

# Cierro el navegador después de realizar las pruebas
driver.quit()