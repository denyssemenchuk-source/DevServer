export default defineEventHandler(async (event) => {
  const body = await readBody(event)

  console.log('Отримано дані підписки:', body)

  return {
    success: true,
    message: 'Subscription created successfully!',
    data: body
  }
})
